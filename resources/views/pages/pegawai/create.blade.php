@extends('layouts.master')

@section('title', 'Pegawai')

@section('page-breadcrumb')
<li class="breadcrumb-item text-muted">Data Master</li>
<li class="breadcrumb-item text-muted">Pegawai</li>
<li class="breadcrumb-item fw-bold">Tambah Data</li>
@endsection

@section('content')

<a href="{{ route('admin.pegawai.index') }}" class="btn btn-light border">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white fw-bold">
                Tambah Data Pegawai
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-bold mb-2">
                        Terjadi kesalahan:
                    </div>

                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="formPegawai" action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label for="name">Nama <span class="text-danger">*</span></label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control my-2" required>
                        </div>
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label for="role">Role <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-select my-2" required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>
                                    Pilih Role
                                </option>

                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="kader" {{ old('role') == 'kader' ? 'selected' : '' }}>
                                    Kader
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-control my-2" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control my-2" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label mb-0">Password <span class="text-danger">*</span></label>
                                <button type="button"
                                    class="btn btn-sm btn-link p-0 text-decoration-none"
                                    onclick="togglePassword()">
                                    <i id="eyeIcon" class="bi bi-eye"></i>
                                </button>
                            </div>
                            <input id="password" type="password" name="password" class="form-control my-2" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="foto">
                                Foto Profile (Max 2 MB)
                            </label>

                            <input
                                type="file"
                                name="foto"
                                id="foto"
                                class="form-control my-2"
                                accept="image/*">

                            <div class="mt-3 d-none" id="previewContainer">
                                <img
                                    id="previewFoto"
                                    class="rounded"
                                    width="150"
                                    height="150"
                                    style="object-fit: cover; aspect-ratio: 1/1;">
                            </div>
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
    const form = document.getElementById('formPegawai');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Simpan Data?',
            text: 'Data pegawai akan disimpan.',
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

<!-- preview foto -->
<script>
    const fotoInput = document.getElementById('foto');
    const previewFoto = document.getElementById('previewFoto');
    const previewContainer = document.getElementById('previewContainer');

    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();

        reader.onload = function(event) {
            previewFoto.src = event.target.result;
            previewContainer.classList.remove('d-none');
        }

        reader.readAsDataURL(file);
    });
</script>

<!-- toggle mata password -->
<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.getElementById("eyeIcon");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>
@endpush