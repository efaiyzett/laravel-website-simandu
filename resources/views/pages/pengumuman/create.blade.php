@extends('layouts.master')

@section('title', 'Pengumuman')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Layanan</li>
<li class="breadcrumb-item text-muted">Pengumuman</li>
<li class="breadcrumb-item fw-bold">Tambah Data</li>
@endsection

<style>
    #preview img {
        height: 150px;
        width: 100%;
        object-fit: cover;
    }

    .remove-image {
        z-index: 10;
        width: 28px;
        height: 28px;
        padding: 0;
        border-radius: 50%;
    }
</style>

@section('content')

<a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white fw-bold">
                Tambah Data Pengumuman
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengumuman.store') }}" method="POST" id="formPengumuman" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="keterangan" id="editor"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dokumentasi <span class="text-danger">*</span></label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="form-control">
                    </div>

                    <div id="preview" class="row mt-3"></div>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    ClassicEditor
    .create(document.querySelector('#editor'), {
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
    });
</script>

<!-- konfirmasi simpan data -->
<script>
    const form = document.getElementById('formPengumuman');

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

<!-- preview -->
<script>
const input = document.getElementById('images');
const preview = document.getElementById('preview');

let dt = new DataTransfer();

input.addEventListener('change', function() {

    for (let file of this.files) {
        dt.items.add(file);
    }

    input.files = dt.files;
    renderPreview();
});

function renderPreview() {

    preview.innerHTML = '';

    Array.from(dt.files).forEach((file, index) => {

        const reader = new FileReader();

        reader.onload = function(e) {

            const div = document.createElement('div');
            div.className = 'col-md-3 mb-3';

            div.innerHTML = `
                <div class="position-relative border rounded p-2">
                    
                    <button type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-image"
                            data-index="${index}">
                        ✕
                    </button>

                    <img src="${e.target.result}"
                         class="img-fluid rounded"
                         style="height:150px;width:100%;object-fit:cover;">
                </div>
            `;

            preview.appendChild(div);

            div.querySelector('.remove-image').addEventListener('click', function() {
                removeFile(index);
            });
        };

        reader.readAsDataURL(file);
    });
}

function removeFile(index) {

    const newDt = new DataTransfer();

    Array.from(dt.files).forEach((file, i) => {
        if (i !== index) {
            newDt.items.add(file);
        }
    });

    dt = newDt;
    input.files = dt.files;

    renderPreview();
}
</script>
@endpush