@extends('layouts.master')

@section('title', 'Input Pemeriksaan Ibu Hamil')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Ibu Hamil</li>
<li class="breadcrumb-item text-muted">Pemeriksaan</li>
<li class="breadcrumb-item fw-bold">{{ $pemeriksaan->ibuhamil->nama}}</li>
@endsection

@section('content')
@php
$role = auth()->user()->role;
@endphp

@if ($errors->any())
<div class="alert alert-danger mt-4">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<a href="{{ route($role.'.ibu.view', $pemeriksaan->ibuhamil_id) }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-gender-female me-2"></i>Form Pemeriksaan Ibu Hamil</h5>
            </div>
            <div class="card-body p-4">
                <form id="formPemeriksaanIbuHamil" action="{{ route($role.'.ibu.pemeriksaan.update', $pemeriksaan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Pilih Ibu Hamil <span class="text-danger">*</span></label>
                            <p><strong>{{ $pemeriksaan->ibuhamil->nama }}</strong></p>
                        </div>
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Berat Badan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.1" class="form-control" name="berat" value="{{ $pemeriksaan->berat }}" placeholder="Contoh: 65.5" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Hari Pertama Haid Terakhir (HPHT) <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="hpht" value="{{ $pemeriksaan->hpht }}" required>
                        </div>
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold"> Hari Perkiraan Lahir (HPL) </label>
                            <input type="date" class="form-control" name="hpl" value="{{ $pemeriksaan->hpl }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pemeriksaan Darah</label>
                        <textarea class="form-control" name="pemeriksaan_darah" rows="3" placeholder="Masukkan hasil pemeriksaan darah...">{{ $pemeriksaan->pemeriksaan_darah }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const form = document.getElementById('formPemeriksaanIbuHamil');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Update Data?',
            text: 'Data pemeriksaan ibu hamil akan diupdate.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            confirmButtonColor: '#0d6efd',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@endpush