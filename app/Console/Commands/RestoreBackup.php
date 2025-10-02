<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RestoreBackup extends Command
{
    protected $signature = 'backup:restore {file}';
    protected $description = 'Restore PostgreSQL database from a backup file';

    public function handle()
    {
        $file = $this->argument('file'); // path ke file .dump atau .sql
        $db   = config('database.connections.pgsql.database');
        $user = config('database.connections.pgsql.username');
        $pass = config('database.connections.pgsql.password');
        $host = config('database.connections.pgsql.host');
        $port = config('database.connections.pgsql.port');

        // Set env password biar tidak ditanya
        putenv("PGPASSWORD={$pass}");

        if (str_ends_with($file, '.dump')) {
            // format custom (pg_dump -F c)
            $process = new Process([
                '/opt/homebrew/opt/postgresql@15/bin/pg_restore', // sesuaikan path pg_restore kamu
                '-h',
                $host,
                '-p',
                $port,
                '-U',
                $user,
                '-d',
                $db,
                '-c', // drop objects before restoring
                $file
            ]);
        } else {
            // format SQL biasa
            $process = new Process([
                'psql',
                '-h',
                $host,
                '-p',
                $port,
                '-U',
                $user,
                '-d',
                $db,
                '-f',
                $file
            ]);
        }

        $process->setTimeout(3600);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if ($process->isSuccessful()) {
            $this->info("Database restored successfully from {$file}");
        } else {
            $this->error("Restore failed: " . $process->getErrorOutput());
        }
    }
}
