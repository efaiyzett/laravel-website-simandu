@extends('layouts.master')

@section('title', 'Input Pemeriksaan Ibu Hamil')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Ibu Hamil</li>
<li class="breadcrumb-item fw-bold">Pemeriksaan</li>
@endsection

@section('content')
@php
$role = auth()->user()->role;
@endphp

<a href="{{ route($role.'.ibu.pemeriksaan.create') }}" class="btn btn-outline-primary me-2">Pemeriksaan Awal</a>
<a href="{{ route($role.'.ibu.tensi.create') }}" class="btn btn-primary">Rutinan</a>

@if ($errors->any())
<div class="alert alert-danger mt-4">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-droplet me-2"></i>Form Tensi</h5>
            </div>
            <div class="card-body p-4">
                <form id="formPemeriksaanIbuHamil" action="{{ route($role.'.ibu.tensi.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Tanggal Pemeriksaan</label>
                            <input type="date" name="tanggal_periksa" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Pilih Ibu Hamil <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="ibuhamil_id" required>
                                <option value="">-- Cari Nama Ibu Hamil --</option>
                                @foreach($ibuhamil as $ibu)
                                <option value="{{ $ibu->id }}">{{ $ibu->nama }} (NIK: {{ $ibu->nik }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Tekanan Darah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="tensi" placeholder="Contoh: 120/80" required>
                                <span class="input-group-text">mmHg</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
            title: 'Simpan Data?',
            text: 'Data pemeriksaan ibu hamil akan disimpan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            confirmButtonColor: '#0d6efd',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endpush