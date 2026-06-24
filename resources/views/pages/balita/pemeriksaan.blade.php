@extends('layouts.master')

@section('title', 'Input Pemeriksaan Balita')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Balita</li>
<li class="breadcrumb-item fw-bold">Pemeriksaan</li>
@endsection

@section('content')
@php $role = auth()->user()->role; @endphp
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-clipboard2-plus me-2"></i>Form Pemeriksaan Balita</h5>
            </div>
            <div class="card-body p-4">
                <form id="formPemeriksaanBalita" action="{{ route($role.'.balita.pemeriksaan.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Tanggal Pemeriksaan</label>
                            <input type="date" name="tanggal_pemeriksaan" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label fw-semibold">Pilih Balita <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="balita_id" required>
                                <option value="">-- Cari Nama Balita --</option>
                                @foreach($balita as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }} (NIK: {{ $b->nik }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Berat Badan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" name="berat" placeholder="Contoh: 12.5" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Tinggi / Panjang Badan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.1" class="form-control" name="tinggi" placeholder="Contoh: 85.5" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Pilih Imunisasi & Catatan <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <div class="card border-0 bg-light p-3 h-100">
                                        <h6 class="fw-bold text-primary mb-2 border-bottom pb-2">Usia 0-11 Bulan</h6>
                                        <div class="row">
                                            @foreach($imunisasi_dasar as $item)
                                            <div class="col-12 col-lg-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="imunisasi" value="{{ $item->id }}" id="imun_{{ $item->id }}" required>
                                                    <label class="form-check-label" style="font-size: 0.85rem;" for="imun_{{ $item->id }}">{{ $item->imunisasi }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="card border-0 bg-light p-3 h-100">
                                        <h6 class="fw-bold text-primary mb-2 border-bottom pb-2">Usia 18-24 Bulan</h6>
                                        <div class="row">
                                            @foreach($imunisasi_lanjutan as $item)
                                            <div class="col-12 col-lg-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="imunisasi" value="{{ $item->id }}" id="imun_{{ $item->id }}" required>
                                                    <label class="form-check-label" style="font-size: 0.85rem;" for="imun_{{ $item->id }}">{{ $item->imunisasi }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <textarea class="form-control form-control-sm" name="catatan" rows="2" placeholder="Tulis catatan (opsional)..."></textarea>
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
    const form = document.getElementById('formPemeriksaanBalita');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan Data?',
            text: 'Pastikan data pemeriksaan sudah benar.',
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