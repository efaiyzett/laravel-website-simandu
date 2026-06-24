@extends('layouts.master')

@section('title', 'Pegawai')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Pegawai</li>
<li class="breadcrumb-item fw-bold">View Data</li>
@endsection

@section('content')

<a href="{{ route('admin.pegawai.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12">
        <div class="card p-4">
            <div class="d-flex justify-content-start mb-4 align-items-center">
                @if ($pegawai->foto)
                <img src="{{ Storage::url($pegawai->foto) }}"
                    alt="Foto {{ $pegawai->name }}"
                    class="rounded-circle me-3"
                    width="100"
                    height="100"
                    style="object-fit: cover;">
                @endif
                <div class="">
                    <h2 class="fw-bold">{{ $pegawai->name }}</h2>
                    <span class="badge rounded-pill px-3 py-2 {{ $pegawai->role == 'admin' 
                        ? 'bg-primary-subtle text-primary' 
                        : 'bg-success-subtle text-success' }}">{{ $pegawai->role }}</span>
                </div>
            </div>
            <table class="table">
                <tr>
                    <th style="width: 200px;">Nama</th>
                    <td class="fw-bold">{{ $pegawai->name }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td class="fw-bold">{{ $pegawai->username }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td class="fw-bold">{{ $pegawai->email }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection