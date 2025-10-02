<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RunBackup extends Command
{
    protected $signature = 'backup:run {--only-db} {--only-files}';
    protected $description = 'Backup database and files (Postgres/MySQL supported)';

    public function handle()
    {
        $this->info('Starting backup: ' . now());

        $backupRoot = config('backupmanager.backup_path', storage_path('app/backups'));
        $date = date('Y-m-d_H-i-s');
        $folder = "{$backupRoot}/backup_{$date}";

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        // 1) database
        if (!$this->option('only-files')) {
            $this->info('Backing up database...');
            try {
                $dbFile = $this->backupDatabase($folder);
                $this->info("Database backup created: {$dbFile}");
            } catch (\Throwable $e) {
                $this->error("Database backup failed: " . $e->getMessage());
            }
        }

        // 2) files
        if (!$this->option('only-db')) {
            $this->info('Backing up files...');
            try {
                $filesArchive = $this->backupFiles($folder);
                $this->info("Files backup created: {$filesArchive}");
            } catch (\Throwable $e) {
                $this->error("Files backup failed: " . $e->getMessage());
            }
        }

        // 3) compress folder into single tar.gz
        $archiveName = "{$backupRoot}/backup_{$date}.tar.gz";
        $this->info('Compressing backup folder...');
        $tarCmd = ["tar", "-czf", $archiveName, "-C", $backupRoot, basename($folder)];
        $process = new Process($tarCmd);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error("Compression failed: " . $process->getErrorOutput());
        } else {
            // optionally cleanup extracted folder
            $this->rrmdir($folder);
            $this->info("Archive created: {$archiveName}");
        }

        // 4) rotate old backups
        $this->rotateBackups($backupRoot);

        $this->info('Backup finished: ' . now());
        return 0;
    }

    protected function backupDatabase(string $folder): string
    {
        $connection = config('database.default');
        $dbConfig = config("database.connections.{$connection}");
        if (!$dbConfig) {
            throw new \RuntimeException("Database connection '{$connection}' not found in config.");
        }

        $driver = $dbConfig['driver'];
        $host = $dbConfig['host'] ?? '127.0.0.1';
        $port = $dbConfig['port'] ?? ($driver === 'pgsql' ? 5432 : 3306);
        $database = $dbConfig['database'] ?? '';
        $username = $dbConfig['username'] ?? '';
        $password = $dbConfig['password'] ?? '';

        if ($driver === 'pgsql') {
            $pgDump = trim(shell_exec('which pg_dump')) ?: 'pg_dump';
            $outFile = "{$folder}/{$database}_" . date('Ymd_His') . '.dump';
            // Use PGPASSWORD env to avoid interactive prompt. Be aware of security implications.
            $cmd = [
                'pg_dump',
                '-h',
                $host,
                '-p',
                (string)$port,
                '-U',
                $username,
                '-F',
                'c', // custom format (compressed)
                '-b', // include blobs
                '-f',
                $outFile,
                $database,
            ];

            $process = new Process($cmd);
            $process->setEnv(array_merge($_SERVER, [
                'PGPASSWORD' => $password
            ]));
            $process->setTimeout(3600);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return $outFile;
        }

        if ($driver === 'mysql') {
            $mysqldump = trim(shell_exec('which mysqldump')) ?: 'mysqldump';
            $outFile = "{$folder}/{$database}_" . date('Ymd_His') . '.sql';
            // Use MYSQL_PWD env to avoid showing password in process list (safer than -pPASSWORD)
            $cmd = [
                $mysqldump,
                '--single-transaction',
                '--routines',
                '--events',
                '-h',
                $host,
                '-P',
                (string)$port,
                '-u',
                $username,
                $database,
            ];

            $process = new Process($cmd);
            $process->setEnv(array_merge($_SERVER, [
                'MYSQL_PWD' => $password
            ]));
            // redirect output to file
            $process->run(function ($type, $buffer) use ($outFile) {
                file_put_contents($outFile, $buffer, FILE_APPEND);
            });

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return $outFile;
        }

        throw new \RuntimeException("Driver '{$driver}' not supported by this script.");
    }

    protected function backupFiles(string $folder): string
    {
        $includes = config('backupmanager.include_folders', []);
        $filesList = [];
        foreach ($includes as $p) {
            if (file_exists($p)) $filesList[] = $p;
        }

        if (empty($filesList)) {
            $this->info('No files/folders to include.');
            return '';
        }

        // create a folder inside $folder to copy files (or use tar directly)
        $copyFolder = "{$folder}/files";
        mkdir($copyFolder, 0755, true);

        // We will archive directly using tar to avoid copying huge data twice
        $tarArgs = ['tar', '-czf', "{$folder}/files_" . date('Ymd_His') . '.tar.gz', '-C', '/',];
        // for tar -C / path1 path2 ... we need to pass relative absolute paths trimmed leading /
        $paths = [];
        foreach ($filesList as $p) {
            $paths[] = ltrim($p, '/');
        }
        $tarCmd = array_merge($tarArgs, $paths);
        $process = new Process($tarCmd);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return "{$folder}/files_" . date('Ymd_His') . '.tar.gz';
    }

    protected function rotateBackups(string $backupRoot)
    {
        $keepDays = (int) config('backupmanager.keep_days', 10);
        if ($keepDays <= 0) return;

        $files = glob("{$backupRoot}/*.tar.gz");
        foreach ($files as $f) {
            $mtime = filemtime($f);
            if ($mtime === false) continue;
            if ($mtime < strtotime("-{$keepDays} days")) {
                @unlink($f);
                $this->info("Deleted old backup: {$f}");
            }
        }
    }

    // helper remove directory recursively
    protected function rrmdir($dir)
    {
        if (!is_dir($dir)) return;
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object == "." || $object == "..") continue;
            $path = $dir . DIRECTORY_SEPARATOR . $object;
            if (is_dir($path)) $this->rrmdir($path);
            else @unlink($path);
        }
        @rmdir($dir);
    }
}
