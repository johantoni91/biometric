<?php

namespace App\Http\Controllers;

use App\Helpers\ValidateHelp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Vinkla\Hashids\Facades\Hashids;

class UserController extends Controller
{
    function index()
    {
        $data = User::paginate(10);
        return view("layouts.user_management.index", compact('data'));
    }

    function search(Request $request)
    {
        $data = User::query()
            ->when($request->name, fn($q) => $q->where('name', 'like', "%{$request->name}%"))
            ->when($request->email, fn($q) => $q->orWhere('email', 'like', "%{$request->email}%"))
            ->when($request->nip, fn($q) => $q->orWhere('nip', 'like', "%{$request->nip}%"))
            ->when($request->satker, fn($q) => $q->orWhere('satker', 'like', "%{$request->satker}%"))
            ->paginate(10);

        $data->appends([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'satker' => $request->satker,
        ]);
        return view('layouts.user_management.index', compact('data'));
    }

    function create()
    {
        return view("layouts.user_management.create");
    }

    function store(Request $request)
    {
        $request->validate(ValidateHelp::register());
        User::create([
            'id'        => mt_rand(),
            'name'      => $request->name,
            'nip'       => $request->nip,
            'photo'     => $request->photo ? $request->file('photo')->store('users', 'public') : null,
            'satker'    => $request->satker,
            'role'      => $request->role,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);
        Alert::success('Berhasil', 'Berhasil membuat user');
        return redirect()->route('users.index');
    }

    function edit($id)
    {
        $user = User::find(Hashids::decode($id)[0]);
        return view("layouts.user_management.edit", [
            'user' => $user,
            'id' => $user->id
        ]);
    }

    function update(Request $request, $id)
    {
        $request->validate(ValidateHelp::update($id));

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan.');
        }

        $user->name = $request->name;
        $user->nip = $request->nip;
        $user->satker = $request->satker;
        $user->role = $request->role;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            $user->photo && Storage::disk('public')->delete($user->photo);
            $user->photo = $request->file('photo')->store('users', 'public');
        }

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        Alert::success('Berhasil', 'Berhasil mengubah ' . $request->name);
        return redirect()->route('users.index')->with('success', 'Berhasil mengupdate user.');
    }

    function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan.');
        }
        $user->photo && Storage::disk('public')->delete($user->photo);
        $user->delete();

        Alert::success('Berhasil', 'Berhasil menghapus user');
        return redirect()->route('users.index')->with('success', 'Berhasil menghapus user.');
    }
}
