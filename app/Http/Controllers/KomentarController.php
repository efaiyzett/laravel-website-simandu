<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function index()
    {
        $komentar = Komentar::all();
        return view('pages.komentar.index', compact('komentar'));
    }

    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->delete();

        return redirect()
            ->route('admin.komentar.index')
            ->with('success', 'Komentar berhasil dihapus.');
    }

    public function balas(Request $request, $id)
    {
        $request->validate([
            'balasan_admin' => 'required|string|max:500',
        ]);
        $komentar = Komentar::findOrFail($id);
        $komentar->update([
            'balasan_admin' => $request->balasan_admin,
            'dibalas_pada' => now(),
        ]);
        return redirect()
            ->back()
            ->with('success', 'Balasan berhasil disimpan.');
    }

    public function hapusBalasan($id)
    {
        $komentar = Komentar::findOrFail($id);

        $komentar->update([
            'balasan_admin' => null,
            'dibalas_pada' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Balasan berhasil dihapus.');
    }
}
