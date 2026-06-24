@extends('layouts.master')

@section('title', 'Komentar')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Layanan</li>
<li class="breadcrumb-item fw-bold">Komentar</li>
@endsection

<style>
    #komentarTable td.komentar {
        width: 600px;
        white-space: normal !important;
        word-break: break-word;
    }

    #komentarTable td:last-child {
        white-space: nowrap;
    }
</style>

@section('content')
<h2 class="fw-bold">Data Komentar</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 p-3 p-md-4">
            <div class="col-12 col-md-4 mb-3">
                <select name="status" id="status" class="form-select">
                    <option value="">-- Pilih Status --</option>
                    <option value="dibalas">Dibalas</option>
                    <option value="belum">Belum</option>
                </select>
            </div>
            <div class="table-responsive">
                <table id="komentarTable" class="table table-hover align-middle w-100">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">NO</th>
                            <th>NAMA</th>
                            <th>KOMENTAR</th>
                            <th>STATUS</th>
                            <th>BALASAN</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($komentar as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->nama }}</td>
                            <td class="komentar">{{ $data->komentar }}</td>
                            <td>
                                @if($data->balasan_admin)
                                <span class="badge bg-success-subtle text-success">
                                    Dibalas
                                </span>
                                @else
                                <span class="badge bg-danger-subtle text-danger">
                                    Belum
                                </span>
                                @endif
                            </td>
                            <td class="komentar">{{ $data->balasan_admin ?: '-' }}</td>
                            <td class="text-center">
                                @if($data->balasan_admin)
                                <button
                                    class="btn btn-link"
                                    data-bs-toggle="modal"
                                    data-bs-target="#balasModal"
                                    data-id="{{ $data->id }}"
                                    data-nama="{{ $data->nama }}"
                                    data-komentar="{{ $data->komentar }}"
                                    data-balasan="{{ $data->balasan_admin }}">
                                    <i class="bi bi-pencil me-2"></i>
                                </button>
                                @else
                                <button
                                    class="btn btn-link"
                                    data-bs-toggle="modal"
                                    data-bs-target="#balasModal"
                                    data-id="{{ $data->id }}"
                                    data-nama="{{ $data->nama }}"
                                    data-komentar="{{ $data->komentar }}"
                                    data-balasan="{{ $data->balasan_admin }}">
                                    <i class="bi bi-chat-left-text"></i>
                                </button>
                                @endif
                                <form action="{{ route('admin.komentar.destroy', $data->id) }}"
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

<!-- balas -->
<div class="modal fade" id="balasModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formBalas" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle">Balasan</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text"
                            id="nama"
                            class="form-control"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label>Komentar</label>
                        <textarea id="komentar"
                            class="form-control"
                            rows="3"
                            readonly></textarea>
                    </div>
                    <div>
                        <label>Balasan Admin</label>
                        <textarea
                            name="balasan_admin"
                            id="balasan_admin"
                            class="form-control"
                            rows="4"
                            required></textarea>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Batal
                </button>
                <form id="hapusBalasanForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn btn-danger">
                        Hapus Balasan
                    </button>
                </form>
                <button type="submit"
                    form="formBalas"
                    class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- datatable -->
<script>
    $(document).ready(function() {
        let table = $('#komentarTable').DataTable({
            order: [],
            responsive: true,
            autoWidth: false,
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

        $('#status').on('change', function() {
            let value = $(this).val();

            table.column(3).search(value).draw();
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

<!-- balasan -->
<script>
    const modal = document.getElementById('balasModal');
    modal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const komentar = button.getAttribute('data-komentar');
        const balasan = button.getAttribute('data-balasan');
        document.getElementById('nama').value = nama;
        document.getElementById('komentar').value = komentar;
        document.getElementById('balasan_admin').value = balasan;
        document.getElementById('formBalas').action =
            `komentar/balas/${id}`;
        document.getElementById('hapusBalasanForm').action =
            `komentar/balas/delete/${id}`;
        document.getElementById('btnHapusBalasan').style.display =
            balasan ? 'inline-block' : 'none';

    });
</script>
@endpush