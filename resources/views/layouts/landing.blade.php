<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-link {
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #0d6efd !important;
        }

        section {
            padding-top: 80px;
            padding-bottom: 80px;
        }

        /* Warna Custom Terang */
        .bg-light-blue {
            background-color: #e9f2fb;
            transition: background-color 0.3s ease;
        }

        /* Warna Custom Gelap */
        [data-bs-theme="dark"] .bg-light-blue {
            background-color: #0d1b2a;
        }

        [data-bs-theme="dark"] .navbar {
            border-bottom: 1px solid #2b3035 !important;
        }

        .transition-link {
            transition: 0.3s;
        }

        .transition-link:hover {
            color: #25D366 !important;
            opacity: 1 !important;
        }

        /* wa */
        .wa-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 1000;
            transition: transform 0.2s ease;
        }

        .wa-float img {
            width: 35px;
            height: 35px;
        }

        .wa-float:hover {
            transform: scale(1.1);
        }

        /* responsive */
        @media (max-width: 768px) {

            h3 {
                font-size: 1.2rem;
            }

            .card-body {
                padding: 1rem !important;
            }

            table {
                font-size: 13px;
            }

            th, td {
                white-space: nowrap;
            }

            .bg-primary.text-white {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body class="bg-body d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-body shadow-sm sticky-top">
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand fw-bold" href="#">
                <img src="{{ asset('storage/images/Logo_Posyandu.png') }}" alt="" width="35" height="35" class="me-2">
                SIMANDU EUPHORBIA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#jadwal">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#jadwal">Pengumuman</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#informasi">Edukasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#kontak">Kontak</a></li>
                </ul>
                <div class="d-flex justify-content-center justify-content-lg-end mt-3 mt-lg-0 align-items-center">
                    <!-- Tombol Dark Mode -->
                    <button class="btn btn-outline-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" id="themeToggle" style="width: 40px; height: 40px;" title="Ubah Tema">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                    <!-- Tombol Login -->
                    <a href="#" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="offcanvas" data-bs-target="#loginSidebar">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="loginSidebar">
        <div class="offcanvas-header border-bottom">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('storage/images/Logo_Posyandu.png') }}" width="80" class="mb-3" alt="Logo">
                <h4 class="fw-bold">Selamat Datang</h4>
                <p class="text-muted">Silakan login untuk mengakses sistem SIMANDU</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text"
                        name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}">

                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">Password</label>
                        <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none" onclick="togglePassword()">
                            <i id="eyeIcon" class="bi bi-eye"></i>
                        </button>
                    </div>
                    <input type="password"
                        id="passwordInput"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror">

                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-50 rounded-pill">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <section id="kontak" class="bg-dark text-white py-5">
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <h4 class="fw-bold mb-3 d-flex align-items-center">
                        <img src="{{ asset('storage/images/Logo_Posyandu.png') }}" alt="" width="30" class="me-2 bg-white rounded-circle">
                        SIMANDU
                    </h4>
                    <p class="text-light text-opacity-75 small">
                        Sistem Informasi Manajemen Posyandu.<br>
                        Mempermudah pencatatan dan akses informasi kesehatan masyarakat tingkat desa.
                    </p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">Informasi Kontak</h5>
                    <ul class="list-unstyled text-light text-opacity-75 small">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Posyandu Gerbangmas Siaga Euphorbia, Ds. Kunir Lor, Kab. Lumajang</li>
                        <li class="mb-2">
                            <a href="https://wa.me/6282232799979" target="_blank" class="text-light text-opacity-75 text-decoration-none transition-link">
                                <i class="bi bi-whatsapp me-2"></i> +62 822-3279-9979 (Kader)
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#beranda" class="text-light text-opacity-75 text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="#jadwal" class="text-light text-opacity-75 text-decoration-none">Jadwal Posyandu</a></li>
                        <li class="mb-2"><a href="#informasi" class="text-light text-opacity-75 text-decoration-none">Edukasi Kesehatan</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-4">
            <div class="text-center text-light text-opacity-50 small mt-3">
                &copy; {{ date('Y') }} SIMANDU
            </div>
        </div>
    </section>

    <a href="https://wa.me/6282232799979" class="wa-float" target="_blank">
        <img src="{{ asset('storage/images/whatsapp.png') }}" alt="WhatsApp">
    </a>

    <!-- SweetAlert2 js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const input = document.getElementById("passwordInput");
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

        const themeToggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;


        const savedTheme = localStorage.getItem('simanduTheme') || 'light';
        setTheme(savedTheme);

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
        });

        function setTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('simanduTheme', theme);


            if (theme === 'dark') {
                themeIcon.classList.remove('bi-moon-fill');
                themeIcon.classList.add('bi-sun-fill');
                themeToggleBtn.classList.replace('btn-outline-secondary', 'btn-outline-light');
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-fill');
                themeToggleBtn.classList.replace('btn-outline-light', 'btn-outline-secondary');
            }
        }
    </script>

    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const offcanvasElement = document.getElementById('loginSidebar');
            const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        });
    </script>
    @endif

    @stack('scripts')
    </body>
</html>