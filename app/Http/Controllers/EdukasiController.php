<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasi = Edukasi::all();
        return view('pages.edukasi.index', compact('edukasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $gambarPath = $request->file('gambar')->store('edukasi', 'public');
        Edukasi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
        ]);
        return redirect()->back()->with('success', 'Artikel Edukasi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $edukasi = Edukasi::findOrFail($id);
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
        ];
        if ($request->hasFile('gambar')) {
            if ($edukasi->gambar && Storage::disk('public')->exists($edukasi->gambar)) {
                Storage::disk('public')->delete($edukasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('edukasi', 'public');
        }
        $edukasi->update($data);
        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        if ($edukasi->gambar && Storage::disk('public')->exists($edukasi->gambar)) {
            Storage::disk('public')->delete($edukasi->gambar);
        }
        $edukasi->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus!');
    }
}