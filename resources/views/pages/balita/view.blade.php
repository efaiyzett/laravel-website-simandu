@extends('layouts.master')

@section('title', 'Balita')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Balita</li>
<li class="breadcrumb-item text-muted">Data Balita</li>
<li class="breadcrumb-item fw-bold">View Data</li>
@endsection

@section('content')

<style>
    .chart-container{
        position: relative;
        height: 350px;
        width: 100%;
    }

    @media (max-width: 768px){
        .chart-container{
            height: 250px;
        }
    }
</style>

@php
$role = auth()->user()->role;
@endphp

<a href="{{ route($role.'.balita.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12 col-lg-5 mb-4">
        <div class="card p-4 h-100">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary"
                    style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-baby text-white fs-1"></i>
                </div>

                <h4 class="fw-bold mt-3">{{ $balita->nama }}</h4>

                <h5 class="text-muted">
                    <i class="bi bi-person-fill"></i> {{$umur}} Tahun
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th style="width: 200px;">NIK</th>
                        <td class="fw-bold">{{ $balita->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ortu</th>
                        <td class="fw-bold">{{ $balita->nama_ortu }}</td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td class="fw-bold">{{ $balita->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td class="fw-bold">{{ \Carbon\Carbon::parse($balita->tgl_lahir)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td class="fw-bold">{{ $balita->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7 mb-4">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-3">Grafik Pertumbuhan Balita</h5>
                <div class="chart-container">
                    <canvas id="pertumbuhanChart"></canvas>
                </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Riwayat Pemeriksaan</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>NO</th>
                            <th>BERAT</th>
                            <th>TINGGI</th>
                            <th>RIWAYAT KESEHATAN (IMUNISASI)</th>
                            <th>TANGGAL PERIKSA</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemeriksaan as $data)
                        <tr>
                            <td>{{ $pemeriksaan->firstItem() + $loop->index }}</td>
                            <td><span class="fw-bold">{{ $data->berat }}</span> kg</td>
                            <td><span class="fw-bold">{{ $data->tinggi }}</span> cm</td>
                            <td>
                                
                                <span class="badge bg-info text-dark mb-1">
                                    {{ str_replace(['Imunisasi: ', '.'], '', $data->imunisasi->imunisasi) }}
                                </span>

                                
                                @if(!empty($data->catatan))
                                <div class="mt-2 text-muted small border-top pt-1">
                                    <strong>Catatan:</strong><br>
                                    {{ $data->catatan }}
                                </div>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_pemeriksaan)->translatedFormat('d F Y') }}</td>
                            <td>
                                <a href="{{ route($role.'.balita.pemeriksaan.edit', $data->id) }}"><i class="bi bi-pencil me-2"></i></a>
                                <form action="{{ route($role.'.balita.pemeriksaan.destroy', $data->id) }}"
                                    method="POST"
                                    class="d-inline formDelete">
    
                                    @csrf
                                    @method('DELETE')
    
                                    <button type="submit" class="border-0 bg-transparent text-primary p-0 m-0">
                                        <i class="bi bi-trash"></i>
                                    </button>
    
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fa-solid fa-file-medical fs-1 text-muted mb-3"></i>
                                <h6 class="fw-bold">Belum Ada Data Pemeriksaan</h6>
                                <a href="{{ route($role.'.balita.pemeriksaan.create', $balita->id) }}"
                                    class="btn btn-primary">
                                    <i class="fa-solid fa-plus me-1"></i>
                                    Tambah Pemeriksaan
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3 d-flex justify-content-end">
                    {{ $pemeriksaan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('pertumbuhanChart').getContext('2d');
        
        // Data dari PHP
        const labels = {!! $labels !!};
        const beratData = {!! $beratData !!};
        const tinggiData = {!! $tinggiData !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Berat Badan (kg)',
                        data: beratData,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#dc3545',
                        yAxisID: 'y',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Tinggi Badan (cm)',
                        data: tinggiData,
                        borderColor: '#0d6efd', // Warna biru
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#0d6efd',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + (context.datasetIndex === 0 ? ' kg' : ' cm');
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Berat Badan (kg)' },
                        min: 0
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Tinggi Badan (cm)' },
                        grid: { drawOnChartArea: false },
                        min: 0
                    }
                }
            }
        });
    });
</script>

<!-- notifikasi ketika ada data yang disimpan -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<!-- konfirmasi hapus -->
<script>
    $('.formDelete').submit(function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data yang dihapus tidak bisa dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

@endpush