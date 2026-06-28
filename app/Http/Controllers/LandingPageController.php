<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\Edukasi;
use App\Models\Dokumentasi;
use App\Models\IbuHamil;
use App\Models\Komentar;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\Tensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $jadwal = Layanan::where('status', 'active')->orderBy('tanggal', 'desc')->take(2)->get();
        $jadwal->map(function ($j) {
            $carbonDate = Carbon::parse($j->tanggal);
            $j->hari = $carbonDate->format('d');
            $j->bulan_tahun = $carbonDate->translatedFormat('M y');
            return $j;
        });
        $pengumuman = Pengumuman::where('status', 'active')->orderBy('created_at', 'desc')->take(2)->get();
        $edukasi = Edukasi::latest()->get();
        $komentar = Komentar::latest()
            ->take(5)
            ->get();
        $jumlah = Komentar::count();
        $jenis = null;
        $data = null;
        $hasil = null;
        $error = null;
        $tensi = null;
        if ($request->filled('nik')) {
            $nik = $request->nik;
            $balita = Balita::where('nik', $nik)->first();
            if ($balita) {
                $jenis = 'Balita';
                $data = $balita;
                $hasil = PemeriksaanBalita::where('balita_id', $balita->id)
                    ->latest()
                    ->get();
            } else {
                $ibu = IbuHamil::where('nik', $nik)->first();
                if ($ibu) {
                    $jenis = 'Ibu Hamil';
                    $data = $ibu;
                    $hasil = PemeriksaanIbuHamil::where('ibuhamil_id', $ibu->id)
                        ->latest()
                        ->first();
                    $tensi = Tensi::where('ibuhamil_id', $ibu->id)
                        ->latest('tanggal_periksa')
                        ->get();
                } else {
                    $error = 'Data tidak ditemukan';
                }
            }
        }

        return view('landing.landing_page', compact(
            'jadwal',
            'pengumuman',
            'edukasi',
            'komentar',
            'jumlah',
            'jenis',
            'data',
            'hasil',
            'error',
            'tensi'
        ));
    }

    public function edukasi($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        return view('landing.edukasi_detail', compact('edukasi'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::where('status', 'active')->orderBy('created_at', 'desc')->get();
        return view('landing.pengumuman', compact('pengumuman'));
    }

    public function pengumuman_detail($id)
    {
        $pengumuman = Pengumuman::where('status', 'active')->findOrFail($id);
        $dokumentasi = Dokumentasi::where('pengumuman_id', '=', $id)->get();
        $pengumumanLain = Pengumuman::where('id', '!=', $id)
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();
        return view('landing.pengumuman_detail', compact('pengumuman', 'pengumumanLain', 'dokumentasi'));
    }

    public function jadwal()
    {
        $jadwal = Layanan::all();
        return view('landing.jadwal', compact('jadwal'));
    }

    public function kirim_komentar(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'komentar' => 'required|string|max:500',
        ]);

        Komentar::create($data);

        return redirect()
            ->route('landing')
            ->with('success', 'Komentar berhasil ditambahkan.')
            ->withFragment('komentar');
    }

    public function load_komentar(Request $request)
    {
        $offset = (int) $request->offset;
        $komentar = Komentar::latest()
            ->skip($offset)
            ->take(5)
            ->get();
        return response()->json(
            $komentar->map(function ($k) {
                return [
                    'nama' => $k->nama,
                    'komentar' => $k->komentar,
                    'created_at' =>
                    $k->created_at->diffForHumans(),
                    'balasan_admin' =>
                    $k->balasan_admin,
                    'dibalas_pada' =>
                    $k->dibalas_pada
                        ? $k->dibalas_pada->diffForHumans()
                        : null,
                ];
            })
        );
    }

    public function sitemap()
{
    $content = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>'.url('/').'</loc>
            <lastmod>'.now()->toAtomString().'</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>
        </url>';

    // Tambahkan link dinamis jika perlu (Contoh: untuk edukasi)
    $edukasis = \App\Models\Edukasi::all();
    foreach ($edukasis as $e) {
        $content .= '
        <url>
            <loc>'.route('landing.edukasi', $e->id).'</loc>
            <lastmod>'.$e->updated_at->toAtomString().'</lastmod>
            <priority>0.8</priority>
        </url>';
    }

    $content .= '</urlset>';

    return response($content)->header('Content-Type', 'application/xml');
}
}
