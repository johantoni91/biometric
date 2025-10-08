<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainingSupport;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'loginView'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [AuthController::class, 'profileView'])->name('profile');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // USER MANAGEMENT
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');
    Route::resource('users', UserController::class);

    // TRAINING SUPPORT
    Route::resource('training-support', TrainingSupport::class);

    Route::group(
        [
            'prefix' => 'backupmanager'
        ],
        function () {
            // list backups
            Route::get('/', [BackupController::class, 'index'])->name('backupmanager');

            // create backups
            Route::post('create', [BackupController::class, 'createBackup'])->name('backupmanager_create');

            // restore/delete backups
            Route::post(
                'restore_delete',
                [BackupController::class, 'restoreOrDeleteBackups']
            )->name('backupmanager_restore_delete');

            // download backup
            Route::get('download/{file}', [BackupController::class, 'download'])->name('backupmanager_download');
        }
    );
});
