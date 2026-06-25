@extends('layouts.landing')

@section('title', 'Edukasi Detail')

<style>
    .artikel-card {
        overflow: hidden;
    }

    .artikel-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        display: block;
    }

    .artikel-content {
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
        white-space: pre-line;
    }
</style>

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card artikel-card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <a href="{{ url('/') }}#informasi"
                            class="btn btn-outline-secondary btn-sm mb-3">
                            ← Kembali
                        </a>
                    </div>
                    <div class="mb-4">
                        <span class="badge bg-primary">
                            Informasi & Edukasi Kesehatan
                        </span>
                        <h1 class="fw-bold mt-3 mb-3">
                            {{ $edukasi->judul }}
                        </h1>
                        <hr>
                        <img
                            src="{{ Storage::disk('s3')->url($edukasi->gambar) }}"
                            alt="{{ $edukasi->judul }}"
                            class="artikel-image rounded-4 mb-4">
                        <div class="artikel-content fs-5 text-secondary">
                            {!! $edukasi->isi !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection