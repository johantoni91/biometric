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

    // BACKUP MANAGER
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/download/{file}', [BackupController::class, 'download'])->name('backup.download');
    Route::post('/backup/restore/{file}', [BackupController::class, 'restore'])->name('backup.restore');
    Route::delete('/backup/{file}', [BackupController::class, 'destroy'])->name('backup.destroy');
});
