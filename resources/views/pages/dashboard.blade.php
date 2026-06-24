@extends('layouts.master')

@section('title', 'Dashboard Admin')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Main Menu</li>
<li class="breadcrumb-item fw-bold">Dashboard</li>
@endsection

<style>
    .list-periksa {
        text-decoration: none;
        color: #6c757d;
        display: block;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all .2s ease;
    }

    .list-periksa:hover {
        background-color: #f8f9fa;
        color: black;
        transform: translateX(3px);
    }
</style>

@section('content')
@php
$role = auth()->user()->role;
@endphp

<h2 class="fw-bold mb-4">Selamat Datang, <span class="text-primary">{{ auth()->user()->name }}</span></h2>

<div class="row my-4">
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card p-4 shadow-sm border-0 border-start border-primary border-4 rounded-3 h-100">
            <p class="text-muted fw-bold mb-1">Total Balita</p>
            <h2 class="fw-bold mb-0 text-primary">{{ $jumlahBalita }}</h2>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card p-4 shadow-sm border-0 border-start border-success border-4 rounded-3 h-100">
            <p class="text-muted fw-bold mb-1">Total Ibu Hamil</p>
            <h2 class="fw-bold mb-0 text-success">{{ $jumlahIbuHamil }}</h2>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card p-4 shadow-sm border-0 border-start border-warning border-4 rounded-3 h-100">
            <p class="text-muted fw-bold mb-1">Kegiatan Akan Datang</p>
            <h2 class="fw-bold mb-0 text-warning">{{ $kegiatanAkanDatang }}</h2>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card p-4 shadow-sm border-0 border-start border-info border-4 rounded-3 h-100">
            <p class="text-muted fw-bold mb-1">Kegiatan Selesai</p>
            <h2 class="fw-bold mb-0 text-info">{{ $kegiatanSelesai }}</h2>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-12 col-lg-6 mb-3">
        <div class="card p-4 shadow-sm border-0 rounded-3">
            <h5 class="fw-bold mb-4">Grafik Pemeriksaan Balita</h5>
            <canvas id="grafikBalita" height="300"></canvas>
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-3">
        <div class="card p-4 shadow-sm border-0 rounded-3">
            <h5 class="fw-bold mb-4">Grafik Pemeriksaan Ibu Hamil</h5>
            <canvas id="grafikIbuHamil" height="300"></canvas>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card p-4 shadow-sm border-0 rounded-3 h-100">
            <h5 class="fw-bold mb-4">Balita Belum Diperiksa</h5>

            @forelse($balitaBelumDiperiksa as $balita)
            <a href="{{ route($role.'.balita.view', $balita->id) }}" class="list-periksa mb-2">
                <div class="d-flex justify-content-between border-bottom pb-2">
                    <span>{{ $balita->nama }}</span>
                </div>
            </a>
            @empty
            <span class="text-muted">
                Semua balita sudah diperiksa
            </span>
            @endforelse
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card p-4 shadow-sm border-0 rounded-3 h-100">
            <h5 class="fw-bold mb-4">Ibu Hamil Belum Diperiksa</h5>

            @forelse($ibuHamilBelumDiperiksa as $ibu)
            <a href="{{ route($role.'.ibu.view', $ibu->id) }}" class="list-periksa mb-2">
                <div class="d-flex justify-content-between border-bottom pb-2">
                    <span>{{ $ibu->nama }}</span>
                </div>
            </a>
            @empty
            <span class="text-muted">
                Semua ibu hamil sudah diperiksa
            </span>
            @endforelse
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-3">
        <div class="card p-4 shadow-sm border-0 rounded-3 h-100">
            <h5 class="fw-bold mb-4">Jadwal Terdekat</h5>

            @forelse($jadwalTerdekat as $jadwal)
            <div class="border-bottom pb-2 mb-2">
                <div class="d-flex justify-content-between">
                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
                    </small>
                    <div class="fw-bold">
                        {{ $jadwal->judul_kegiatan }}
                    </div>
                </div>

            </div>
            @empty
            <span class="text-muted">
                Tidak ada jadwal mendatang
            </span>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const bulan = [
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];

    new Chart(document.getElementById('grafikBalita'), {
        type: 'line',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Pemeriksaan Balita',
                data: @json($grafikBalita),
                fill: true,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('grafikIbuHamil'), {
        type: 'line',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Pemeriksaan Ibu Hamil',
                data: @json($grafikIbuHamil),
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });
</script>
@endpush