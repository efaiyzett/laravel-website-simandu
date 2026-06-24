@extends('layouts.master')

@section('title', 'Jadwal')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Layanan</li>
<li class="breadcrumb-item text-muted">Jadwal</li>
<li class="breadcrumb-item fw-bold">View Data</li>
@endsection

@section('content')

<a href="{{ route('admin.layanan.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12">
        <div class="card p-4">
            <h2 class="fw-bold">Judul Kegiatan: {{ $layanan->judul_kegiatan }}</h2>
            <table class="table">
                <tr>
                    <th style="width: 200px;">Lokasi</th>
                    <td class="fw-bold">{{ $layanan->lokasi }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td class="fw-bold">{{ $layanan->tanggal }}</td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td class="fw-bold">{{ $layanan->waktu_mulai }} - {{ $layanan->waktu_selesai }} WIB</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td class="fw-bold">{{ $layanan->keterangan }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td class="fw-bold">
                        <span class="badge rounded-pill px-3 py-2
                                {{ $layanan->status == 'active' 
                                    ? 'bg-success-subtle text-success' 
                                    : 'bg-danger-subtle text-danger' }}">

                            {{ ucfirst($layanan->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection