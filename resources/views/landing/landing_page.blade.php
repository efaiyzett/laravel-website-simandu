@extends('layouts.landing')

@section('title', 'SIMANDU - Posyandu Gerbangmas Siaga Euphorbia')

@section('content')
<section id="beranda" class="bg-light-blue py-5">
    <div class="container mt-5">
        <div class="row align-items-center text-center text-lg-start">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="fw-bold display-5 text-primary">Sistem Informasi Manajemen Posyandu</h1>
                <p class="text-body-secondary mt-3 fs-5">
                    SIMANDU hadir untuk mempermudah pencatatan, pelaporan, dan akses informasi kesehatan masyarakat secara digital.
                </p>
                <a href="#jadwal" class="btn btn-primary rounded-pill px-4 mt-3 py-2 me-2 shadow-sm">Lihat Jadwal</a>
                <a href="#profil" class="btn btn-outline-primary rounded-pill px-4 mt-3 py-2 shadow-sm bg-body">Profil Kami</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('storage/images/posyandu2.png') }}"
                    alt="Ilustrasi Posyandu Ibu dan Anak"
                    class="img-fluid rounded-4 shadow border border-3 border-white"
                    style="width: 100%; height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<section id="profil" class="bg-body">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="fw-bold text-primary">Profil Posyandu</h2>
                <div style="width: 60px; height: 4px; background-color: #0d6efd; margin: 0 auto;"></div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div id="profilCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#profilCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#profilCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#profilCarousel" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#profilCarousel" data-bs-slide-to="3"></button>
                    </div>
                    <div class="carousel-inner rounded-4 shadow">
                        <div class="carousel-item active">
                            <img src="{{ asset('storage/images/a (1).jpeg') }}" class="d-block w-100" style="height: 300px; object-fit: cover;" alt="Profil Posyandu 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('storage/images/a (2).jpeg') }}" class="d-block w-100" style="height: 300px; object-fit: cover;" alt="Profil Posyandu 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('storage/images/a (3).jpeg') }}" class="d-block w-100" style="height: 300px; object-fit: cover;" alt="Profil Posyandu 3">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('storage/images/a (4).jpeg') }}" class="d-block w-100" style="height: 300px; object-fit: cover;" alt="Profil Posyandu 4">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#profilCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#profilCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <div class="col-lg-7">
                <h4 class="fw-bold text-body">Posyandu Gerbangmas Siaga Euphorbia Kunir</h4>
                <p class="text-danger mb-2 fw-semibold"><i class="bi bi-geo-alt me-2"></i> Kabupaten Lumajang</p>
                <p class="text-body-secondary mt-3">
                    Kami berkomitmen untuk meningkatkan kesehatan ibu dan anak di lingkungan kami melalui pelayanan yang terpadu dan rutin. Melalui SIMANDU, kami mendigitalisasi pencatatan pelayanan guna meningkatkan akurasi data balita dan ibu hamil serta mempermudah masyarakat mengakses jadwal dan edukasi kesehatan.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="jadwal" class="bg-body-tertiary">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-7 mb-4">
                <h3 class="fw-bold text-primary mb-4 text-center text-lg-start">Jadwal Posyandu Terdekat</h3>
                @foreach($jadwal as $j)
                <div class="card border-0 shadow-sm rounded-4 mb-3 bg-body">
                    <div class="card-body p-4" style="min-height: 130px;">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $j->judul_kegiatan }}</h5>
                                <p class="text-body-secondary mb-0 small"><i class="bi bi-clock me-1"></i> {{ $j->waktu_mulai }} - {{ $j->waktu_selesai }} WIB | <i class="bi bi-geo-alt ms-2 me-1"></i> {{ $j->lokasi }}</p>
                            </div>
                            <div class="bg-primary text-white text-center rounded-3 p-2 px-3 align-self-start">
                                <span class="d-block fw-bold fs-5">{{ $j->hari }}</span>
                                <span class="d-block small">{{ $j->bulan_tahun }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="text-center mt-3">
                    <a href="{{ route('landing.jadwal') }}"
                    class="btn btn-outline-primary rounded-3 px-4">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-5 mb-4">
                <h3 class="fw-bold text-primary mb-4 text-center text-lg-start">Pengumuman Kegiatan</h3>
                @php
                $colors = [
                'text-bg-primary',
                'text-bg-success',
                'text-bg-warning',
                'text-bg-danger',
                'text-bg-info',
                ];
                @endphp

                @foreach($pengumuman as $p)
                <a href="{{ route('landing.pengumuman_detail', $p->id) }}" style="text-decoration: none;">
                    <div class="card {{ $colors[$p->id % count($colors)] }} border-0 shadow-sm rounded-4 p-4 mb-3 bg-opacity-75" style="min-height: 130px;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="card-title fw-bold">
                                <i class="bi bi-megaphone me-2"></i>Pengumuman
                            </span>
                            <small class="text-muted">
                                {{ $p->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <h5 class="fw-bold mb-2 text-truncate" style="max-width: 100%;">
                            "{{ $p->judul }}"
                        </h5>
                    </div>
                </a>
                @endforeach
                <div class="text-center mt-3">
                    <a href="{{ route('landing.pengumuman') }}"
                    class="btn btn-outline-primary rounded-3 px-4">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="card border-0 shadow-sm rounded-4 mb-3 bg-body">
                    <div class="card-body p-4">
                        <form action="{{ route('landing') }}#jadwal" method="GET">
    <label class="fw-bold mb-2 text-primary">
        <i class="bi bi-search me-2"></i>Cari Riwayat Kesehatan
    </label>
    
    <div class="d-flex">
        <input
            type="text"
            name="nik"
            class="form-control"
            placeholder="Masukkan NIK Balita / Ibu Hamil"
            required>
        <button
            class="btn btn-primary ms-2 px-4">
            Cari
        </button>
    </div>
    
    <small class="text-muted mt-2 d-block">
        <i class="bi bi-info-circle me-1"></i> Gunakan kolom ini untuk mencari data diri dan riwayat pemeriksaan kesehatan Balita atau Ibu Hamil berdasarkan NIK.
    </small>
</form>
                        <div id="hasilCari">
                            @if($error)
                                <div class="alert alert-danger mt-4">
                                    {{ $error }}
                                </div>
                            @elseif($jenis=='Balita')
                                <h4 class="mt-4">Data Diri Balita</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width: 250px;">Nama</th>
                                            <td>{{ $data->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>{{ $data->nik }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>{{ \Carbon\Carbon::parse($data->tgl_lahir)->translatedFormat('d F Y') }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <h4>Riwayat Pemeriksaan Balita</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Berat</th>
                                                <th>Tinggi</th>
                                                <th>Riwayat Kesehatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hasil as $item)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->translatedFormat('d F Y') }}</td>
                                                <td>{{ $item->berat }} kg</td>
                                                <td>{{ $item->tinggi }} cm</td>
                                                <td>
                                                    {{ $item->imunisasi->imunisasi }} <br>
                                                    <small>catatan: {{$item->catatan}}</small>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($jenis=='Ibu Hamil')
                                <h4 class="mt-4">Data Diri Ibu Hamil</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width: 250px;">Nama</th>
                                            <td>{{ $data->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>{{ $data->nik }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>{{ \Carbon\Carbon::parse($data->tgl_lahir)->translatedFormat('d F Y') }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <h4 class="mt-4">Riwayat Pemeriksaan</h4>
                                @if ($hasil)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width: 250px;">HPHT</th>
                                                <td>{{ $hasil->hpht }}</td>
                                            </tr>
                                            <tr>
                                                <th>HPL</th>
                                                <td>{{ $hasil->hpl }}</td>
                                            </tr>
                                            <tr>
                                                <th>berat</th>
                                                <td>{{ $hasil->berat }} kg</td>
                                            </tr>
                                            <tr>
                                                <th>Pemeriksaan darah</th>
                                                <td>{{ $hasil->pemeriksaan_darah }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Pemeriksaan</th>
                                                <td>{{ \Carbon\Carbon::parse($hasil->tanggal_pemeriksaan)->translatedFormat('d F Y') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @else
                                    Belum ada data
                                @endif

                                <h4 class="mt-4">Riwayat Tensi</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Tensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tensi as $item)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_periksa)->translatedFormat('d F Y') }}</td>
                                                <td>{{ $item->tensi }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="informasi" class="bg-body">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="fw-bold text-primary">Informasi & Edukasi Kesehatan</h2>
                <div style="width: 60px; height: 4px; background-color: #0d6efd; margin: 0 auto;"></div>
            </div>
        </div>

        <div class="row">
            @forelse($edukasi as $e)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 bg-body">
                    <img src="{{ asset('storage/' . $e->gambar) }}"
                        class="card-img-top rounded-top-4"
                        alt="{{ $e->judul }}"
                        style="height: 180px; object-fit: cover;">
                    <div class="card-body p-4 d-flex flex-column">
                        <span class="badge bg-primary bg-opacity-25 text-primary mb-2 align-self-start">{{ $e->kategori }}</span>
                        <h5 class="card-title fw-bold">{{ $e->judul }}</h5>
                        <p class="card-text text-body-secondary small">{!! Str::limit(strip_tags($e->isi), 100) !!}</p>
                        <a href="{{ route('landing.edukasi', $e->id) }}" class="btn btn-link px-0 text-decoration-none fw-bold mt-auto align-self-start">
                            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-body-secondary">
                <p>Belum ada artikel edukasi kesehatan yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>


<section id="komentar" class="bg-body-tertiary">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="fw-bold me-3">{{ $jumlah }} Komentar</h5>
        </div>
        <div class="card h-100 border-0 shadow-sm rounded-4 bg-body">
            <div class="card-body p-4">
                <div class="kirim-komentar border-bottom">
                    <form action="{{ route('landing.kirim_komentar') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama..." maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="komentar">Komentar <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="komentar" id="komentar" rows="6" maxlength="500" required></textarea>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-primary" type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
                <div id="listKomentar" class="komentar pt-4">
                    @foreach ($komentar as $k)
                    <div class="mb-4">
                        <span class="fw-bold">{{ $k->nama }}</span>
                        <span class="text-muted">· {{ $k->created_at->diffForHumans() }}</span>
                        <p class="mb-2">
                            {{ $k->komentar }}
                        </p>
                        @if($k->balasan_admin)
                        <div class="ms-4 border-start ps-3">
                            <span class="fw-bold text-primary">Admin Posyandu</span>
                            <span class="text-muted">· {{ $k->dibalas_pada?->diffForHumans() }}</span>
                            <p class="mb-0">
                                {{ $k->balasan_admin }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($jumlah > 5)
                <div class="text-center">
                    <button
                        id="showMoreBtn"
                        class="btn btn-outline-primary">
                        Lihat Lebih Banyak
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
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

<script>
    let offset = 5;
    const total = {{ $jumlah }};
    const btn = document.getElementById('showMoreBtn');
    btn?.addEventListener('click', async function () {
        try {
            const response = await fetch(
                `{{ route('landing.load_komentar') }}?offset=${offset}`
            );
            const data = await response.json();
            const container = document.getElementById('listKomentar');
            data.forEach(item => {
                container.innerHTML += `
                <div class="mb-4">
                    <span class="fw-bold">
                        ${item.nama}
                    </span>
                    <span class="text-muted">
                        · ${item.created_at}
                    </span>
                    <p class="mb-2">
                        ${item.komentar}
                    </p>
                    ${item.balasan_admin ?
                    `<div class="ms-4 border-start ps-3">
                        <span class="fw-bold text-primary">
                            Admin Posyandu
                        </span>
                        <span class="text-muted">
                            · ${item.dibalas_pada}
                        </span>
                        <p class="mb-0">
                            ${item.balasan_admin}
                        </p>
                    </div>`
                    : ''}
                </div>
                `;
            });
            offset += data.length;
            if (data.length === 0) {
                btn.style.display = 'none';
                return;
            }
        } catch (error) {
            console.error(error);
        }
    });
</script>
@endpush