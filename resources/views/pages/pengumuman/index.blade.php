@extends('layouts.master')

@section('title', 'Pengumuman')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Layanan</li>
<li class="breadcrumb-item fw-bold">Pengumuman</li>
@endsection

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <h2 class="fw-bold">Pengumuman</h2>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 p-3 p-md-4">
            <div class="table-responsive">
                <table id="pengumumanTable" class="table table-hover align-middle nowrap w-100">
                    <thead class="table-primary">
                        <tr>
                            <th>NO</th>
                            <th>JUDUL</th>
                            <th>KETERANGAN</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengumuman as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;">
                                    {{ $data->judul }}
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;">
                                    {{ $data->keterangan }}
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input change-status"
                                        type="checkbox"
                                        data-id="{{ $data->id }}"
                                        {{ $data->status == 'active' ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.pengumuman.edit', $data->id) }}"><i class="bi bi-pencil me-2"></i></a>
                                <form action="{{ route('admin.pengumuman.destroy', $data->id) }}"
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
        let table = $('#pengumumanTable').DataTable({
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

<!-- ganti status -->
<script>
    $('.change-status').change(function() {
        let id = $(this).data('id');
        let status = $(this).is(':checked') ? 'active' : 'inactive';
        $.ajax({
            url: `/admin/pengumuman/status/${id}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Status gagal diubah'
                });
            }
        });
    });
</script>

@endpush