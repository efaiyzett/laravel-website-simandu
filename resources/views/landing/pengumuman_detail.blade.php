@extends('layouts.landing')

@section('title', 'Pengumuman Detail')

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
        line-height: 1.9;
    }

    .artikel-content h1,
    .artikel-content h2,
    .artikel-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .artikel-content p {
        margin-bottom: 1rem;
    }

    .artikel-content img {
        max-width: 100%;
        border-radius: 12px;
        margin: 20px auto;
        display: block;
    }

    .artikel-content ul,
    .artikel-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }

    .artikel-content table {
        width: 100%;
        margin-bottom: 1rem;
    }
</style>

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card artikel-card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <a href="{{ url('/') }}#jadwal"
                            class="btn btn-outline-secondary btn-sm mb-3">
                            ← Kembali
                        </a>
                    </div>
                    <div class="mb-4">
                        <span class="badge bg-primary">
                            Pengumuman
                        </span>

                        <h1 class="fw-bold mt-3 mb-3">
                            {{ $pengumuman->judul }}
                        </h1>
                    </div>
                    <hr>
                    <div class="artikel-content fs-5">
                        {!! $pengumuman->keterangan !!}
                    </div>
                    @php
                        $total = $dokumentasi->count();
                    @endphp

                    @if($total)
                        <hr>
                        <h5 class="fw-bold mb-3">Dokumentasi</h5>

                        <div class="row g-3">
                            @foreach($dokumentasi as $d)
                                <div class="{{ $total == 1 ? 'col-12' : 'col-12 col-md-6' }}">
                                    <img
                                        src="{{ Storage::disk('s3')->url($d->path) }}"
                                        class="img-fluid rounded shadow-sm w-100"
                                        style="max-height:300px; object-fit:contain;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mt-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        Pengumuman Lainnya
                    </h5>
                    <div class="row g-3">
                        @foreach($pengumumanLain as $item)
                        <div class="col-md-6">
                            <a href="{{ route('landing.pengumuman_detail',$item->id) }}"
                                class="text-decoration-none text-dark">
                                <div class="card h-100 border">
                                    <div class="card-body">
                                        <span class="badge bg-primary mb-2">
                                            Pengumuman
                                        </span>
                                        <h6 class="fw-bold">
                                            {{ Str::limit($item->judul, 50) }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $item->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection