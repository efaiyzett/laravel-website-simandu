<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::all();
        return view('pages.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pages.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'keterangan' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $pengumuman = Pengumuman::create([
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'status' => 'active',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {

                $path = Storage::disk('s3')->putFile(
                    'dokumentasi',
                    $file
                );

                Dokumentasi::create([
                    'pengumuman_id' => $pengumuman->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::with('dokumentasi')->findOrFail($id);
        return view('pages.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'keterangan' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        $pengumuman->update([
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = Storage::disk('s3')->putFile(
                    'dokumentasi',
                    $file
                );
                Dokumentasi::create([
                    'pengumuman_id' => $pengumuman->id,
                    'path' => $path,
                ]);
            }
        }

        if ($request->delete_images) {
            $deleted = json_decode($request->delete_images, true);
            foreach ($deleted as $id) {
                $dok = Dokumentasi::find($id);
                if ($dok) {
                    Storage::disk('s3')->delete($dok->path);
                    $dok->delete();
                }
            }
        }

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        foreach ($pengumuman->dokumentasi as $dok) {
            Storage::disk('s3')->delete($dok->path);
            $dok->delete();
        }
        $pengumuman->delete();
        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function change_status(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $pengumuman->status = $request->status;
        $pengumuman->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah'
        ]);
    }
}
