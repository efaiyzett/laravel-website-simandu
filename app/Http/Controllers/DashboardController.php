<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Layanan;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $jumlahBalita = Balita::count();

        $jumlahIbuHamil = IbuHamil::count();

        $kegiatanAkanDatang = Layanan::whereDate('tanggal', '>=', now())
            ->count();

        $kegiatanSelesai = Layanan::whereDate('tanggal', '<', now())
            ->count();

        $balitaBelumDiperiksa = Balita::whereDoesntHave('pemeriksaan', function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal_pemeriksaan', $bulan)
                ->whereYear('tanggal_pemeriksaan', $tahun);
        })->take(5)->get();

        $ibuHamilBelumDiperiksa = IbuHamil::whereDoesntHave('pemeriksaan', function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal_pemeriksaan', $bulan)
                ->whereYear('tanggal_pemeriksaan', $tahun);
        })->take(5)->get();

        $jadwalTerdekat = Layanan::whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        $grafikBalita = [];

        for ($i = 1; $i <= 12; $i++) {
            $grafikBalita[] = PemeriksaanBalita::whereYear('tanggal_pemeriksaan', now()->year)
                ->whereMonth('tanggal_pemeriksaan', $i)
                ->count();
        }

        $grafikIbuHamil = [];

        for ($i = 1; $i <= 12; $i++) {
            $grafikIbuHamil[] = PemeriksaanIbuHamil::whereYear('tanggal_pemeriksaan', now()->year)
                ->whereMonth('tanggal_pemeriksaan', $i)
                ->count();
        }

        return view('pages.dashboard', compact(
            'jumlahBalita',
            'jumlahIbuHamil',
            'kegiatanAkanDatang',
            'kegiatanSelesai',
            'balitaBelumDiperiksa',
            'ibuHamilBelumDiperiksa',
            'jadwalTerdekat',
            'grafikBalita',
            'grafikIbuHamil',
        ));
    }
}
