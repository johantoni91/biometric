<?php

namespace App\Http\Controllers;

use Illuminate\Mail\Message;
use Log;
use Sarfraznawaz2005\BackupManager\Facades\BackupManager;
use Session;
use Storage;

class BackupController extends Controller
{
    // public function __construct()
    // {
    //     if (config('backupmanager.http_authentication')) {
    //         $this->middleware('auth.basic');
    //     }
    // }

    public function index()
    {
        $title = 'Backup List';

        $backups = BackupManager::getBackups();

        return view('layouts.backup_manager.index', compact('title', 'backups'));
    }

    public function createBackup()
    {
        $message = '';
        $mailBody = '';
        $messages = [];

        // create backups
        $result = BackupManager::createBackup();

        // set status messages
        if ($result['f'] === true) {
            $message = 'Files Backup Taken Successfully';

            $messages[] = [
                'type' => 'success',
                'message' => $message
            ];

            Log::info($message);
        } else {
            if (config('backupmanager.backups.files.enable')) {
                $message = 'Files Backup Failed';

                $messages[] = [
                    'type' => 'danger',
                    'message' => $message
                ];

                Log::error($message);
            }
        }

        $mailBody .= $message;

        if ($result['d'] === true) {
            $message = 'Database Backup Taken Successfully';

            $messages[] = [
                'type' => 'success',
                'message' => $message
            ];

            Log::info($message);
        } else {
            if (config('backupmanager.backups.database.enable')) {
                $message = 'Database Backup Failed';

                $messages[] = [
                    'type' => 'danger',
                    'message' => $message
                ];

                Log::error($message);
            }
        }

        $mailBody .= '<br>' . $message;

        $this->sendMail($mailBody);

        \Session::flash('messages', $messages);

        return redirect()->back();
    }

    public function restoreOrDeleteBackups()
    {
        $mailBody = '';
        $messages = [];
        $backups = request()->backups;
        $type = request()->type;

        if ($type === 'restore' && count($backups) > 2) {
            $messages[] = [
                'type' => 'danger',
                'message' => 'Maksimal 2 data backups yang dapat melakukan aksi secara bersamaan.'
            ];

            Session::flash('messages', $messages);
            return redirect()->back();
        }

        if ($type === 'restore') {
            // restore backups

            $results = BackupManager::restoreBackups($backups);

            // set status messages
            foreach ($results as $result) {
                if (isset($result['f'])) {
                    if ($result['f'] === true) {
                        $message = 'Data berhasil dipulihkan';

                        $messages[] = [
                            'type' => 'success',
                            'message' => $message
                        ];

                        Log::info($message);
                    } else {
                        $message = 'Data gagal dipulihkan';

                        $messages[] = [
                            'type' => 'danger',
                            'message' => $message
                        ];

                        Log::error($message);
                    }

                    $mailBody .= $message;
                } elseif (isset($result['d'])) {
                    if ($result['d'] === true) {
                        $message = 'Database berhasil dipulihkan';

                        $messages[] = [
                            'type' => 'success',
                            'message' => $message
                        ];

                        Log::info($message);
                    } else {
                        $message = 'Database gagal dipulihkan';

                        $messages[] = [
                            'type' => 'danger',
                            'message' => $message
                        ];

                        Log::error($message);
                    }

                    $mailBody .= '<br>' . $message;
                }
            }

            $this->sendMail($mailBody);
        } else {
            // delete backups

            $results = BackupManager::deleteBackups($backups);

            if ($results) {
                $messages[] = [
                    'type' => 'success',
                    'message' => 'Backup(s) berhasil dihapus.'
                ];
            } else {
                $messages[] = [
                    'type' => 'danger',
                    'message' => 'Gagal dihapus.'
                ];
            }
        }

        Session::flash('messages', $messages);

        return redirect()->back();
    }

    public function download($file)
    {
        $path = config('backupmanager.backups.backup_path') . DIRECTORY_SEPARATOR . $file;

        $file = Storage::disk(config('backupmanager.backups.disk'))
            ->getDriver()
            ->getAdapter()
            ->getPathPrefix() . $path;

        return response()->download($file);
    }

    protected function sendMail($body)
    {
        try {

            $emails = config('backupmanager.mail.mail_receivers', []);

            if ($emails) {
                foreach ($emails as $email) {
                    \Mail::send([], [], static function (Message $message) use ($body, $email) {
                        $message
                            ->subject(config('backupmanager.mail.mail_subject', 'BackupManager Alert'))
                            ->to($email)
                            ->text($body);
                    });
                }
            }
        } catch (\Exception $e) {
            \Log::error('BackupManager Email Sending Failed: ' . $e->getMessage());
        }
    }
}
