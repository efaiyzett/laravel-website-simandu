<?php

namespace App\Http\Controllers;

use App\Exports\BalitaExport;
use App\Models\Balita;
use App\Models\Imunisasi;
use App\Models\PemeriksaanBalita;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class BalitaController extends Controller
{
    public function index()
    {
        $balita = Balita::latest()->get();
        return view('pages.balita.index', compact('balita'));
    }

    public function create()
    {
        return view('pages.balita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'nama_ortu' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
        ]);
        Balita::create($request->all());
        return redirect()->route(auth()->user()->role . '.balita.index')->with('success', 'Data balita berhasil ditambahkan');
    }

    public function destroy($id)
    {
        Balita::findOrFail($id)->delete();
        return redirect()->route(auth()->user()->role . '.balita.index')->with('success', 'Data balita berhasil dihapus');
    }

    public function edit($id)
    {
        $balita = Balita::findOrFail($id);
        return view('pages.balita.edit', compact('balita'));
    }

    public function update(Request $request, $id)
    {
        Balita::findOrFail($id)->update($request->all());
        return redirect()->route(auth()->user()->role . '.balita.index')->with('success', 'Data balita berhasil diupdate');
    }

    public function view($id)
    {
        $balita = Balita::findOrFail($id);
        $pemeriksaan = PemeriksaanBalita::where('balita_id', $id)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->paginate(5);
        $umur = Carbon::parse($balita->tgl_lahir)->age;

        $chartData = PemeriksaanBalita::where('balita_id', $id)
            ->orderBy('tanggal_pemeriksaan')
            ->get();
        $labels = $chartData->map(function ($item) {
            return Carbon::parse($item->tanggal_pemeriksaan)->translatedFormat('d M Y');
        });
        $beratData = $chartData->pluck('berat');
        $tinggiData = $chartData->pluck('tinggi');

        return view('pages.balita.view', compact('balita', 'pemeriksaan', 'umur', 'labels', 'beratData', 'tinggiData'));
    }

    public function create_pemeriksaan()
    {
        $balita = Balita::all();
        $imunisasi_dasar = Imunisasi::where('jenis', 'dasar')->get();
        $imunisasi_lanjutan = Imunisasi::where('jenis', 'lanjutan')->get();
        return view('pages.balita.pemeriksaan', compact('balita', 'imunisasi_dasar', 'imunisasi_lanjutan'));
    }

    public function store_pemeriksaan(Request $request)
    {
        $request->validate([
            'balita_id' => 'required',
            'berat' => 'required',
            'tinggi' => 'required',
            'tanggal_pemeriksaan' => 'required',
            'imunisasi' => 'required',
        ]);

        PemeriksaanBalita::create([
            'balita_id'           => $request->balita_id,
            'berat'               => $request->berat,
            'tinggi'              => $request->tinggi,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'imunisasi_id'   => $request->imunisasi,
            'catatan'             => $request->catatan,
        ]);

        return redirect()->route(auth()->user()->role . '.balita.pemeriksaan.create')
            ->with('success', 'Pemeriksaan berhasil disimpan!');
    }

    public function edit_pemeriksaan($id)
    {
        $pemeriksaan = PemeriksaanBalita::findOrFail($id);
        $imunisasi_dasar = Imunisasi::where('jenis', 'dasar')->get();
        $imunisasi_lanjutan = Imunisasi::where('jenis', 'lanjutan')->get();
        return view ('pages.balita.edit_pemeriksaan', compact('pemeriksaan', 'imunisasi_dasar', 'imunisasi_lanjutan'));
    }

    public function update_pemeriksaan(Request $request, $id)
    {
        $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'berat'               => 'required|numeric',
            'tinggi'              => 'required|numeric',
            'imunisasi'           => 'required',
            'catatan'             => 'nullable|string',
        ]);

        $pemeriksaan = PemeriksaanBalita::findOrFail($id);

        $pemeriksaan->update([
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'berat'               => $request->berat,
            'tinggi'              => $request->tinggi,
            'imunisasi_id'        => $request->imunisasi,
            'catatan'             => $request->catatan,
        ]);

        return redirect()->route(auth()->user()->role . '.balita.view', $pemeriksaan->balita_id)
            ->with('success', 'Pemeriksaan berhasil disimpan!');
    }

    public function destroy_pemeriksaan($id)
    {
        PemeriksaanBalita::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pemeriksaan berhasil dihapus');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new BalitaExport(
                $request->jenis,
                $request->keterangan
            ),
            'laporan-balita.xlsx'
        );
    }
}
