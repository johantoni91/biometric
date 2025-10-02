<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::files('backups');
        $backups = collect($disk)->map(function ($file) {
            return [
                'file_name' => basename($file),
                'size' => Storage::size($file), // MB
                'date' => Carbon::createFromTimestamp(Storage::lastModified($file))->format('d-m-Y H:i:s'),
                'path' => $file,
            ];
        });
        return view('layouts.backup_manager.index', compact('backups'));
    }

    public function create()
    {
        Artisan::call('backupmanager:create');
        Alert::info('Info', Artisan::output());
        return redirect()->route('backup.index');
    }

    public function download($file)
    {
        $path = "backups/" . $file;

        if (Storage::exists($path)) {
            return Storage::download($path);
        }

        return abort(404, 'File tidak ditemukan');
    }

    public function restore($file)
    {
        Artisan::call('backupmanager:restore');
        Artisan::call($file);
        Alert::success('Sukses', 'Database berhasil direstore!');
        return redirect()->route('backup.index');
    }

    public function destroy($file)
    {
        $hapus = Storage::delete('backups/' . $file);
        if (!$hapus) {
            return back()->with('error', 'Gagal menghapus backup!');
        }
        Alert::success('Sukses', 'Database berhasil dihapus!');
        return redirect()->route('backup.index');
    }
}
