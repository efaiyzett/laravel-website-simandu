<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::latest()->get();
        return view('pages.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('pages.pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'username.unique' => 'Username sudah dipakai.',
            'password.min' => 'Password Minimal 6 karakter.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('profile', 'public');
        }

        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto' => $foto,
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);

        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus');
    }

    public function edit($id)
    {
        $pegawai = User::findOrFail($id);
        return view('pages.pegawai.edit', compact('pegawai'));
    }


    public function update(Request $request, $id)
    {
        $pegawai = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'username' => 'required|unique:users,username,' . $pegawai->id,
            'email' => 'required',
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'username.unique' => 'Username sudah dipakai.',
            'password.min' => 'Password Minimal 6 karakter.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $foto = $pegawai->foto;

        if ($request->hasFile('foto')) {

            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $foto = $request->file('foto')->store('profile', 'public');
        }

        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'username' => $request->username,
            'email' => $request->email,
            'foto' => $foto,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pegawai->update($data);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diupdate');
    }

    public function view($id)
    {
        $pegawai = User::findOrFail($id);
        return view('pages.pegawai.view', compact('pegawai'));
    }
}
