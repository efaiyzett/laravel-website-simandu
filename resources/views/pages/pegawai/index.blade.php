@extends('layouts.master')

@section('title', 'Pegawai')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item fw-bold">Pegawai</li>
@endsection

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <h2 class="fw-bold">Data Pegawai</h2>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 p-3 p-md-4">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <select name="role" id="role" class="form-select">
                        <option value="">
                            -- Semua Role --
                        </option>
                        <option value="admin">Admin</option>
                        <option value="kader">Kader</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table id="pegawaiTable" class="table table-hover align-middle nowrap w-100">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" style="width: 5%;">NO</th>
                            <th>USER</th>
                            <th>USERNAME</th>
                            <th>ROLE</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{ $data->foto 
                                        ? asset('storage/' . $data->foto) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($data->name) }}"
                                        alt="Foto Profile"
                                        class="rounded-circle object-fit-cover me-3"
                                        width="35"
                                        height="35">

                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $data->name }}</span>
                                        <small class="text-muted">{{ $data->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $data->username }}</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2
                                    {{ $data->role == 'admin' 
                                        ? 'bg-primary-subtle text-primary' 
                                        : 'bg-success-subtle text-success' }}">

                                    {{ ucfirst($data->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.pegawai.view', $data->id) }}"><i class="bi bi-eye me-2"></i></a>
                                <a href="{{ route('admin.pegawai.edit', $data->id) }}"><i class="bi bi-pencil me-2"></i></a>
                                <form action="{{ route('admin.pegawai.destroy', $data->id) }}"
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

@endsection

@push('scripts')
<!-- datatable -->
<script>
    $(document).ready(function() {
        let table = $('#pegawaiTable').DataTable({
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

        $('#role').on('change', function() {
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
@endpush