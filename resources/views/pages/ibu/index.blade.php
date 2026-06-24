@extends('layouts.master')

@section('title', 'Ibu Hamil')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Ibu Hamil</li>
<li class="breadcrumb-item fw-bold">Data Ibu Hamil</li>
@endsection

@section('content')

@php
$role = auth()->user()->role;
@endphp

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <h2 class="fw-bold">Data Ibu Hamil</h2>
    <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-light me-2 border"
            data-bs-toggle="modal"
            data-bs-target="#exporModel">
            <i class="bi bi-download me-2"></i>Export
        </button>
        <a href="{{ route($role.'.ibu.create') }}" class="btn btn-primary"><i class="bi bi-plus me-2"></i>Tambah</a>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 p-3 p-md-4">
            <div class="table-responsive">
                <table id="ibuTable" class="table table-hover align-middle nowrap w-100">
                    <thead class="table-primary">
                        <tr>
                            <th>NIK</th>
                            <th>NAMA</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ibuhamil as $data)
                        <tr>
                            <td>{{ $data->nik }}</td>
                            <td>{{ $data->nama }}</td>
                            <td class="text-center">
                                <a href="{{ route($role.'.ibu.view', $data->id) }}"><i class="bi bi-eye me-2"></i></a>
                                <a href="{{ route($role.'.ibu.edit', $data->id) }}"><i class="bi bi-pencil me-2"></i></a>
                                <form action="{{ route($role.'.ibu.destroy', $data->id) }}"
                                    method="POST"
                                    class="d-inline formDelete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent text-primary p-0 m-0">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- modal export -->
<form action="{{ route($role.'.ibu.export') }}" method="GET">
    <div class="modal fade" id="exporModel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export Excel</h5>
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select name="jenis" id="jenis" class="form-select">
                            <option value="master">Data Master</option>
                            <option value="pemeriksaan">Data Pemeriksaan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <select name="keterangan" id="keterangan" class="form-select select2">
                            <option value="semua">Semua Ibu Hamil</option>
                            @foreach($ibuhamil as $data)
                            <option value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                        class="btn btn-primary">
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<!-- datatable -->
<script>
    $(document).ready(function() {
        $('#ibuTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [],
            pagingType: "simple_numbers",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    next: "›",
                    previous: "‹"
                },
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Belum ada data"
            }
        });
    });
</script>

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

<!-- select2 -->
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('#exporModel')
        });
    });
</script>
@endpush