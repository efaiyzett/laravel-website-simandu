@extends('layouts.master')

@section('title', 'Jadwal')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Layanan</li>
<li class="breadcrumb-item text-muted">Jadwal</li>
<li class="breadcrumb-item fw-bold">Tambah Data</li>
@endsection

@section('content')

<a href="{{ route('admin.layanan.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white fw-bold">
                Tambah Data Jadwal Kegiatan
            </div>
            <div class="card-body">
                <form id="formBalita" action="{{ route('admin.layanan.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Pilih Penanggung Jawab <span class="text-danger">*</span></label></label>
                            <select class="form-select select2" name="user_id" required>
                                <option value="">-- Cari Nama Petugas --</option>
                                @foreach($petugas as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-8 mb-3 mb-md-0">
                            <label for="judul_kegiatan">Judul Kegiatan <span class="text-danger">*</span></label>
                            <input id="judul_kegiatan" type="text" name="judul_kegiatan" class="form-control my-2" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label for="lokasi">Lokasi <span class="text-danger">*</span></label>
                            <input id="lokasi" type="text" name="lokasi" class="form-control my-2" required>
                        </div>
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                            <input id="tanggal" type="date" name="tanggal" class="form-control my-2" required>
                        </div>
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label for="waktu_mulai">Waktu Mulai <span class="text-danger">*</span></label>
                            <input id="waktu_mulai" type="time" name="waktu_mulai" class="form-control my-2" required>
                        </div>
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label for="waktu_selesai">Waktu Selesai <span class="text-danger">*</span></label>
                            <input id="waktu_selesai" type="time" name="waktu_selesai" class="form-control my-2" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
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

<!-- select2 -->
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Cari Nama Petugas --',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush