<?php

namespace App\Http\Controllers;

use App\Models\Imunisasi;
use Illuminate\Http\Request;

class ImunisasiController extends Controller
{
    public function index()
    {
        $imunisasi = Imunisasi::all();
        return view('pages.imunisasi.index', compact('imunisasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imunisasi' => 'required',
            'jenis' => 'required',
        ]);

        Imunisasi::create([
            'imunisasi' => $request->imunisasi,
            'jenis' => $request->jenis,
        ]);

        return redirect()
            ->route('admin.imunisasi.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'imunisasi' => 'required|max:255',
            'jenis' => 'required',
        ]);

        $imunisasi = Imunisasi::findOrFail($id);

        $imunisasi->update([
            'imunisasi' => $request->imunisasi,
            'jenis' => $request->jenis,
        ]);

        return redirect()
            ->route('admin.imunisasi.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $imunisasi = Imunisasi::findOrFail($id);
        $imunisasi->delete();

        return redirect()
            ->route('admin.imunisasi.index')
            ->with('success', 'Imunisasi berhasil dihapus.');
    }
}
