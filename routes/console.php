<?php

use App\Console\Commands\RestoreBackup;
use App\Console\Commands\RunBackup;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Artisan::command('backup:run', function () {
//     $this->call(RunBackup::class);
// });

// Artisan::command('backup:restore', function () {
//     $this->call(RestoreBackup::class);
// });
