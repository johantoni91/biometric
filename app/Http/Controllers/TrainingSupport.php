<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Vinkla\Hashids\Facades\Hashids;

class TrainingSupport extends Controller
{
    function index()
    {
        $data = Guide::paginate();
        return view('layouts.training_support.index', compact('data'));
    }

    function create()
    {
        return view('layouts.training_support.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'file'        => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        Guide::create([
            'id'        => uniqid(),
            'title'     => $request->title,
            'content'   => $request->file('file')->store('guides', 'public'),
        ]);

        Alert::success('Berhasil', 'Berhasil menambahkan buku panduan');
        return redirect()->route('training-support.index');
    }

    function destroy($id)
    {
        $data = Guide::findOrFail($id);
        if (Storage::disk('public')->exists($data->content)) {
            Storage::disk('public')->delete($data->content);
        }
        $data->delete();

        Alert::success('Berhasil', 'Berhasil menghapus buku panduan');
        return redirect()->route('training-support.index');
    }

    function show($id)
    {
        $data = Guide::findOrFail($id);
        return response()->file(storage_path('app/public/' . $data->content));
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'file'        => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        $data = Guide::findOrFail($id);
        $data->title = $request->title;

        if ($request->hasFile('file')) {
            $data->content && Storage::disk('public')->delete($data->content);
            $data->content = $request->file('file')->store('guides', 'public');
        }

        $data->save();

        Alert::success('Berhasil', 'Berhasil memperbarui buku panduan');
        return redirect()->route('training-support.index');
    }

    function edit($id)
    {
        $data = Guide::findOrFail(Hashids::decode($id)[0]);
        return view('layouts.training_support.edit', [
            'data' => $data,
            'id' => $data->id
        ]);
    }
}
