@extends('layouts.landing')

@section('title', 'Pengumuman')

<style>
    .pengumuman-item {
        color: inherit;
        display: block;
        transition: all 0.3s ease;
        padding: 15px 0;
        margin-bottom: 10px;
    }

    .pengumuman-item:hover {
        color: #0d6efd;
    }

    .pengumuman-item:hover .card-body {
        transform: translateX(5px);
    }

    .pengumuman-item .card-body {
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
    <h2 class="fw-bold text-primary mb-4">Pengumuman</h2>

    @foreach($pengumuman as $item)
    <a href="{{ route('landing.pengumuman_detail', $item->id) }}"
        class="pengumuman-item text-decoration-none border-bottom mb-3">
        <div class="card-body d-flex">
            <div class="me-3 d-flex align-items-center">
                <i class="bi bi-megaphone-fill megaphone-icon fs-5"></i>
            </div>
            <div>
                <small class="text-muted">
                    <i class="bi bi-calendar3"></i>
                    {{ $item->created_at->format('d F Y') }}
                </small>

                <h5 class="fw-bold mb-0">
                    {{ $item->judul }}
                </h5>
            </div>
        </div>
    </a>
    @endforeach
</div>

@endsection