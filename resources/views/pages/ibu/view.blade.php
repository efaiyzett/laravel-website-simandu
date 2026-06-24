@extends('layouts.master')

@section('title', 'Ibu Hamil')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Ibu Hamil</li>
<li class="breadcrumb-item text-muted">Data Ibu Hamil</li>
<li class="breadcrumb-item fw-bold">View Data</li>
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
    <div class="col-12 col-lg-5 mb-4">
        <div class="card p-4 h-100">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 80px; height: 80px; background-color: #ff69b4;">
                    <i class="fa-solid fa-person-pregnant text-white fs-1"></i>
                </div>

                <h4 class="fw-bold mt-3">{{ $ibuhamil->nama }}</h4>

                <h5 class="text-muted">
                    <i class="bi bi-person-fill"></i> {{$umur}} Tahun
                </h5>
            </div>
            <table class="table">
                <tr>
                    <th style="width: 200px;">NIK</th>
                    <td class="fw-bold">{{ $ibuhamil->nik }}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td class="fw-bold">{{ $ibuhamil->tempat_lahir }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td class="fw-bold">{{ $ibuhamil->tgl_lahir }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td class="fw-bold">{{ $ibuhamil->alamat }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold">Data Pemeriksaan Terakhir</h5>
                @if($pemeriksaan)
                <a href="{{ route($role.'.ibu.pemeriksaan.edit', $pemeriksaan->id) }}"><i class="bi bi-pencil me-2"></i></a>
                @endif
            </div>
            @if($pemeriksaan)
            <table class="table">
                <tr>
                    <th>HPHT</th>
                    <td class="fw-bold">{{ \Carbon\Carbon::parse($pemeriksaan->hpht)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>HPL</th>
                    <td class="fw-bold">{{ \Carbon\Carbon::parse($pemeriksaan->hpl)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Berat</th>
                    <td class="fw-bold">{{ $pemeriksaan->berat }} kg</td>
                </tr>
                <tr>
                    <th>Pemeriksaan Darah</th>
                    <td class="fw-bold">{{ $pemeriksaan->pemeriksaan_darah ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Periksa</th>
                    <td class="fw-bold">{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->translatedFormat('d F Y') }}</td>
                </tr>
            </table>
            @else
            <div class="d-flex flex-column justify-content-center align-items-center text-center"
                style="min-height: 300px;">
                <i class="fa-solid fa-file-medical fs-1 text-muted mb-3"></i>

                <h6 class="fw-bold">Belum Ada Data Pemeriksaan</h6>

                <a href="{{ route($role.'.ibu.pemeriksaan.create', $ibuhamil->id) }}"
                    class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i>
                    Tambah Pemeriksaan
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-3">Tensi</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Tensi</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tensi as $t)
                    <tr>
                        <td>{{ $tensi->firstItem() + $loop->index }}</td>
                        <td class="text-center">{{ $t->tensi  }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($t->tanggal_periksa)->translatedFormat('d F Y')  }}</td>
                        <td class="text-center">
                            <button type="button"
                                class="border-0 bg-transparent text-primary p-0 m-0 btnEditTensi"

                                data-bs-toggle="modal"
                                data-bs-target="#modalEditTensi"

                                data-id="{{ $t->id }}"
                                data-tensi="{{ $t->tensi }}"
                                data-tanggal="{{ $t->tanggal_periksa }}">

                                <i class="bi bi-pencil me-2"></i>
                            </button>
                            <form action="{{ route($role.'.ibu.tensi.destroy', $t->id) }}" method="POST" class="d-inline formDelete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border-0 bg-transparent text-primary p-0 m-0">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-muted text-center">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-end">
                {{ $tensi->links() }}
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

<!-- modal tensi -->
<div class="modal fade" id="modalEditTensi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditTensi" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        Edit Tensi
                    </h5>
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Tensi
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="edit_tensi"
                            name="tensi"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Tanggal Periksa
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            id="edit_tanggal"
                            name="tanggal_periksa"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<!-- notifikasi ketika ada data yang disimpan -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<!-- konfirmasi hapus -->
<script>
    $('.formDelete').submit(function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data yang dihapus tidak bisa dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

<script>
    document.querySelectorAll('.btnEditTensi')
    .forEach(button => {
        button.addEventListener('click', function() {
            let id = this.dataset.id;
            let tensi = this.dataset.tensi;
            let tanggal = this.dataset.tanggal;
            document.getElementById('edit_tensi')
                .value = tensi;
            document.getElementById('edit_tanggal')
                .value = tanggal;
            document.getElementById('formEditTensi')
                .action = `/{{ $role }}/ibuhamil/tensi/${id}`;
        });
    });
</script>
@endpush