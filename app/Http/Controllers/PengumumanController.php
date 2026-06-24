<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

        $manager = new ImageManager(new Driver());
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = uniqid() . '.webp';
                $image = $manager->read($file);
                Storage::disk('public')->put(
                    'dokumentasi/' . $filename,
                    (string) $image->toWebp(80)
                );
                Dokumentasi::create([
                    'pengumuman_id' => $pengumuman->id,
                    'path' => 'dokumentasi/' . $filename
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

        $manager = new ImageManager(new Driver());
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $file) {
                $filename = uniqid() . '.webp';
                $image = $manager->read($file);
                Storage::disk('public')->put(
                    'dokumentasi/' . $filename,
                    (string) $image->toWebp(80)
                );
                Dokumentasi::create([
                    'pengumuman_id' => $pengumuman->id,
                    'path' => 'dokumentasi/' . $filename
                ]);
            }
        }

        if ($request->delete_images) {

            $deleted = json_decode($request->delete_images, true);
            foreach ($deleted as $id) {
                $dok = Dokumentasi::find($id);
                if ($dok) {
                    Storage::disk('public')->delete($dok->path);
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
        $dokumentasi = Dokumentasi::where('pengumuman_id', $id)->get();
        foreach ($pengumuman->dokumentasi as $dok) {
            Storage::disk('public')->delete($dok->path);
            $dok->delete();
        }
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')
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
