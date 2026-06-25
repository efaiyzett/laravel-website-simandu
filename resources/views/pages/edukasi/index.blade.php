@extends('layouts.master')

@section('title', 'Edukasi Kesehatan')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Layanan</li>
<li class="breadcrumb-item fw-bold">Edukasi Kesehatan</li>
@endsection

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <h2 class="fw-bold">Data Edukasi Kesehatan</h2>
    <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdukasi" onclick="resetForm()">
            + Tambah
        </button>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 p-3 p-md-4">
            <div class="table-responsive">
                <table id="edukasiTable" class="table table-hover align-middle nowrap w-100">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" style="width: 5%;">NO</th>
                            <th style="width: 20%;">GAMBAR</th>
                            <th style="width: 60%;">JUDUL & ISI</th>
                            <th class="text-center" style="width: 15%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($edukasi as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><img src="{{ Storage::disk('s3')->url($data->gambar) }}" style="height: 50px; width: 50px; object-fit: cover; border-radius: 8px;"></td>
                            <td>
                                <h6 class="fw-bold mb-1">{{ $data->judul }}</h6>
                                <small class="text-muted">{!! Str::limit(strip_tags($data->isi), 80) !!}</small>
                            </td>
                            <td class="text-center">
                                <a href="#"
                                    class="text-decoration-none me-2 editEdukasi"
                                    data-id="{{ $data->id }}"
                                    data-judul="{{ $data->judul }}"
                                    data-isi="{{ $data->isi }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.edukasi.destroy', $data->id) }}"
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalEdukasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Tambah Artikel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdukasi" action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                        <textarea name="isi" id="editor_tambah"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editEdukasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editEdukasiForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Edukasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" id="editJudul" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi <span class="text-danger">*</span></label>
                        <textarea id="editor_edit" name="isi"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Library CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    let editorTambah;
    let editorEdit;

    // Fungsi Reset Form Tambah
    function resetForm() {
        $('#modalTitle').text('Tambah Artikel');
        $('#formEdukasi').attr('action', "{{ route('admin.edukasi.store') }}");
        $('#methodField').empty();
        $('#formEdukasi')[0].reset();
        
        if (editorTambah) {
            editorTambah.setData('');
        }
    }

    $(document).ready(function() {
        // 1. Inisialisasi DataTable
        $('#edukasiTable').DataTable({
            order: [],
            responsive: true,
            autoWidth: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: { next: "›", previous: "‹" },
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Belum ada data"
            }
        });

        // 2. Inisialisasi CKEditor untuk Modal Tambah
        ClassicEditor
            .create(document.querySelector('#editor_tambah'), {
                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        '|',
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'bulletedList',
                        'numberedList',
                    ]
                }
            })
            .then(editor => { editorTambah = editor; })
            .catch(error => console.error(error));

        // 3. Inisialisasi CKEditor untuk Modal Edit
        ClassicEditor
            .create(document.querySelector('#editor_edit'), {
                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        '|',
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'bulletedList',
                        'numberedList',
                    ]
                }
            })
            .then(editor => { editorEdit = editor; })
            .catch(error => console.error(error));

        // 4. Action Edit Edukasi (Event Delegation untuk DataTable)
        $(document).on('click', '.editEdukasi', function(e) {
            e.preventDefault();
            
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            const isi = $(this).data('isi');
            
            $('#editJudul').val(judul);
            
            // Set isi text editor
            if (editorEdit) {
                editorEdit.setData(isi);
            }
            
            $('#editEdukasiForm').attr('action', `/admin/edukasi/${id}`);
            $('#editEdukasiModal').modal('show');
        });

        // 5. Konfirmasi Hapus Data
        $(document).on('submit', '.formDelete', function(e) {
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
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>

<!-- Notifikasi SweetAlert Success -->
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