@extends('layouts.landing')

@section('title', 'Jadwal')

<style>
    .jadwal-item {
        color: inherit;
        display: block;
        transition: all 0.3s ease;
        padding: 15px 0;
        margin-bottom: 10px;
    }

    .jadwal-item:hover {
        color: #0d6efd;
    }

    .jadwal-item:hover .card-body {
        transform: translateX(5px);
    }

    .jadwal-item .card-body {
        transition: all 0.3s ease;
    }
</style>

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ url('/') }}#jadwal"
            class="btn btn-outline-secondary btn-sm mb-3">
            ← Kembali
        </a>
    </div>
    <h2 class="fw-bold text-primary mb-4">Jadwal Posyandu</h2>

    @foreach($jadwal as $item)
    <div class="jadwal-item text-decoration-none border-bottom mb-3">
        <div class="card-body d-flex">
            <div class="me-3 d-flex align-items-center">
                <i class="bi bi-list-ul fs-5"></i>
            </div>
            <div>
                <small class="text-muted">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $item->tanggal->format('d F Y') }} |
                    <i class="bi bi-clock ms-2 me-1"></i> {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }} WIB | <i class="bi bi-geo-alt ms-2 me-1"></i> {{ $item->lokasi }}
                </small>
                @php
                $selesai = $item->tanggal->isPast();
                @endphp
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold mb-1 me-2">
                        {{ $item->judul_kegiatan }}
                    </h5>
                    <small>
                        <span class="badge {{ $selesai ? 'bg-secondary' : 'bg-success' }}">
                            {{ $selesai ? 'Selesai' : 'Akan Datang' }}
                        </span>
                    </small>
                </div>
                <small>
                    {{ $item->keterangan }}
                </small>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection