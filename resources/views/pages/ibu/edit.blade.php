@extends('layouts.master')

@section('title', 'Ibu Hamil')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Ibu Hamil</li>
<li class="breadcrumb-item text-muted">Data Ibu Hamil</li>
<li class="breadcrumb-item fw-bold">Update Data</li>
@endsection

@section('content')

@php
$role = auth()->user()->role;
@endphp

<a href="{{ route($role.'.ibu.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                Update Data Ibu Hamil
            </div>
            <div class="card-body">
                <form id="formIbuHamil" action="{{ route($role.'.ibu.update', $ibuhamil->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input id="nama" type="text" name="nama" class="form-control my-2" value="{{ $ibuhamil->nama }}" required>
                        </div>
                        <div class="col-6">
                            <label for="nik">NIK <span class="text-danger">*</span></label>
                            <input id="nik" type="number" name="nik" class="form-control my-2" value="{{ $ibuhamil->nik }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                            <input id="tempat_lahir" type="text" name="tempat_lahir" class="form-control my-2" value="{{ $ibuhamil->tempat_lahir }}" required>
                        </div>
                        <div class="col-6">
                            <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input id="tgl_lahir" type="date" name="tgl_lahir" class="form-control my-2" value="{{ $ibuhamil->tgl_lahir }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3">{{ $ibuhamil->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- konfirmasi update data -->
<script>
    const form = document.getElementById('formIbuHamil');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Update Data?',
            text: 'Data ibu hamil akan diupdate.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
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