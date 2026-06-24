@extends('layouts.master')

@section('title', 'Balita')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Balita</li>
<li class="breadcrumb-item text-muted">Data Balita</li>
<li class="breadcrumb-item fw-bold">Tambah Data</li>
@endsection

@section('content')

@php
$role = auth()->user()->role;
@endphp

<a href="{{ route($role.'.balita.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                Tambah Data Balita
            </div>
            <div class="card-body">
                <form id="formBalita" action="{{ route($role.'.balita.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <label for="nama">Nama Bayi <span class="text-danger">*</span></label>
                            <input id="nama" type="text" name="nama" class="form-control my-2" required>
                        </div>
                        <div class="col-4">
                            <label for="nik">NIK <span class="text-danger">*</span></label>
                            <input id="nik" type="number" name="nik" class="form-control my-2" required>
                        </div>
                        <div class="col-4">
                            <label for="nama_ortu">Orang Tua <span class="text-danger">*</span></label>
                            <input id="nama_ortu" type="text" name="nama_ortu" class="form-control my-2" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                            <input id="tempat_lahir" type="text" name="tempat_lahir" class="form-control my-2" required>
                        </div>
                        <div class="col-6">
                            <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input id="tgl_lahir" type="date" name="tgl_lahir" class="form-control my-2" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- konfirmasi simpan data -->
<script>
    const form = document.getElementById('formBalita');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Simpan Data?',
            text: 'Data balita akan disimpan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush