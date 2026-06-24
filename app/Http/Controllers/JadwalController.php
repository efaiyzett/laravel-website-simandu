<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $petugas = User::whereHas('layanan')->distinct()->get();
        $layanan = Layanan::latest()->get();
        return view('pages.jadwal.index', compact('layanan', 'petugas'));
    }

    public function create()
    {
        $petugas = User::where('role', 'kader')->get();
        return view('pages.jadwal.create', compact('petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'judul_kegiatan' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'keterangan' => 'required',
        ]);

        Layanan::create([
            'user_id' => $request->user_id,
            'judul_kegiatan' => $request->judul_kegiatan,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Data jenis layanan berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        $layanan->delete();

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Data jenis layanan berhasil dihapus');
    }

    public function edit($id)
    {
        $petugas = User::where('role', 'kader')->get();
        $layanan = Layanan::findOrFail($id);
        return view('pages.jadwal.edit', compact('petugas', 'layanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'judul_kegiatan' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'keterangan' => 'required',
        ]);

        $layanan = Layanan::findOrFail($id);

        $layanan->update([
            'user_id' => $request->user_id,
            'judul_kegiatan' => $request->judul_kegiatan,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.layanan.index')->with('success', 'Data jenis layanan berhasil diperbarui');
    }

    public function view($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('pages.jadwal.view', compact('layanan'));
    }

    public function change_status(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $layanan->status = $request->status;
        $layanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah'
        ]);
    }
}
