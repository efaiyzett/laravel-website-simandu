@extends('layouts.master')

@section('title', 'Imunisasi')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item fw-bold">Imunisasi</li>
@endsection

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <h2 class="fw-bold">Data Imunisasi</h2>
    <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createImunisasi">
            + Tambah
        </button>
    </div>
</div>

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
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <select name="jenis" id="jenis" class="form-select">
                        <option value="">-- Semua Jenis --</option>
                        <option value="dasar">Dasar</option>
                        <option value="lanjutan">Lanjutan</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table id="imunisasiTable" class="table table-hover align-middle nowrap w-100">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center" style="width: 5%;">NO</th>
                                <th>IMUNISASI</th>
                                <th>JENIS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($imunisasi as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $data->imunisasi }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2
                                    {{ $data->jenis == 'dasar' 
                                        ? 'bg-primary-subtle text-primary' 
                                        : 'bg-success-subtle text-success' }}">

                                        {{ ucfirst($data->jenis) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="#"
                                        class="editImunisasi text-decoration-none"
                                        data-id="{{ $data->id }}"
                                        data-imunisasi="{{ $data->imunisasi }}"
                                        data-jenis="{{ $data->jenis }}">
                                        <i class="bi bi-pencil me-2"></i>
                                    </a>
                                    <form action="{{ route('admin.imunisasi.destroy', $data->id) }}"
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
</div>

<!-- tambah -->
<div class="modal fade" id="createImunisasi" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.imunisasi.store') }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Imunisasi</h5>
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Imunisasi <span class="text-danger">*</span></label>
                        <input type="text"
                            name="imunisasi"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Imunisasi <span class="text-danger">*</span></label><br>
                        <div class="form-check">
                            <input class="form-check-input"
                                type="radio"
                                name="jenis"
                                id="radioDefault1"
                                value="dasar"
                                checked>
                            <label class="form-check-label" for="radioDefault1">
                                Imunisasi Dasar (0-11 Bulan)
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                type="radio"
                                name="jenis"
                                id="radioDefault2"
                                value="lanjutan">
                            <label class="form-check-label" for="radioDefault2">
                                Imunisasi Lanjutan (18-24 Bulan)
                            </label>
                        </div>
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
                        Simpan
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- edit -->
<div class="modal fade" id="editImunisasiModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editImunisasiForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Imunisasi</h5>
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Imunisasi</label>
                        <input type="text"
                            id="inputImunisasi"
                            name="imunisasi"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Imunisasi <span class="text-danger">*</span></label><br>
                        <div class="form-check">
                            <input class="form-check-input"
                                type="radio"
                                name="jenis"
                                id="editDasar"
                                value="dasar"
                                checked>
                            <label class="form-check-label" for="editDasar">
                                Imunisasi Dasar (0-11 Bulan)
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                type="radio"
                                name="jenis"
                                id="editLanjutan"
                                value="lanjutan">
                            <label class="form-check-label" for="editLanjutan">
                                Imunisasi Lanjutan (18-24 Bulan)
                            </label>
                        </div>
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
                        Update
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<!-- datatable -->
<script>
    $(document).ready(function() {
        let table = $('#imunisasiTable').DataTable({
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

        $('#jenis').on('change', function() {
            let value = $(this).val();

            table.column(2).search(value).draw();
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

<!-- edit imunisasi -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.editImunisasi').forEach(button => {

            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                const imunisasi = this.dataset.imunisasi;
                const jenis = this.dataset.jenis;
                document.getElementById('inputImunisasi').value = imunisasi;
                if (jenis === 'dasar') {
                    document.getElementById('editDasar').checked = true;
                } else {
                    document.getElementById('editLanjutan').checked = true;
                }
                document.getElementById('editImunisasiForm').action =
                    `/admin/imunisasi/${id}`;
                new bootstrap.Modal(
                    document.getElementById('editImunisasiModal')
                ).show();
            });
        });
    });
</script>
@endpush