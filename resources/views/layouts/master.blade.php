<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- jetbrain mono font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
            background-color: #f0f4f8;
        }

        /* sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 10px;
            color: #6c757d;
            text-decoration: none;
            transition: 0.2s;
            font-weight: 500;
        }

        .sidebar-link i {
            font-size: 18px;
            margin-right: 10px;
        }

        .sidebar-link:hover {
            background: #f1f5ff;
            color: #0d6efd;
        }

        .sidebar-link.active {
            background: #e7f1ff;
            color: #0d6efd;
            border-left: 4px solid #0d6efd;
            padding-left: 8px;
        }

        .sidebar-section {
            font-family: "JetBrains Mono", monospace;
            font-optical-sizing: auto;
            font-style: normal;
            font-size: 11px;
            letter-spacing: 1px;
            margin-top: 20px;
            margin-bottom: 8px;
            color: #9aa4b2;
            font-weight: 700;
            letter-spacing: 3px;
        }

        /* breadcrumb */
        .breadcrumb {
            font-size: 13px;
        }

        /* table head */
        th {
            font-family: "JetBrains Mono", monospace;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: normal;
            font-size: small;
            letter-spacing: 3px;
        }

        /* content */
        .content {
            background-color: #f0f4f8;
        }

        /* responsive */
        @media (max-width: 768px) {

            body {
                overflow: auto;
            }

            .content {
                padding: 15px !important;
            }

            .topbar {
                padding: 10px !important;
            }

            .breadcrumb {
                font-size: 12px;
            }

            th {
                font-size: 11px;
                letter-spacing: 1px;
            }
        }
    </style>
</head>


<body>
    @php
    $role = auth()->user()->role;
    @endphp

    <!-- sidebar hp -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMobile">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">SIMANDU</h5>
            <button type="button" class="btn-close"
                data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body p-0">
            <ul class="nav flex-column px-3">
                <!-- section main menu -->
                <li class="sidebar-section">MAIN MENU</li>
                <li>
                    <a href="{{ route($role.'.dashboard')}}"
                        class="sidebar-link {{ request()->routeIs($role.'.dashboard') ? 'active' : '' }}">

                        <i class="bi bi-house"></i>
                        Dashboard
                    </a>
                </li>

                <!-- section data master -->
                <li class="sidebar-section">DATA MASTER</li>
                <li>
                    <a class="sidebar-link d-flex justify-content-between align-items-center
                        {{ request()->routeIs($role.'.balita.*') || request()->routeIs($role.'.pemeriksaan-balita.*') ? 'active' : '' }}"
                        data-bs-toggle="collapse"
                        href="#menuBalita"
                        role="button"
                        aria-expanded="false">
                        <span>
                            <i class="fa-solid fa-baby"></i>Balita
                        </span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs($role.'.balita.*') || request()->routeIs($role.'.pemeriksaan-balita.*') ? 'show' : '' }}"
                        id="menuBalita">
                        <ul class="nav flex-column ms-4 mt-1 border-start ps-3">
                            <li>
                                <a href="{{ route($role.'.balita.index') }}"
                                    class="sidebar-link">
                                    Data Balita
                                </a>
                            </li>
                            <li>
                                <a href="{{ route($role.'.balita.pemeriksaan.create') }}"
                                    class="sidebar-link">
                                    Pemeriksaan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="sidebar-link d-flex justify-content-between align-items-center
                        {{ request()->routeIs($role.'.ibu.*') || request()->routeIs($role.'.pemeriksaan-ibu.*') ? 'active' : '' }}"
                        data-bs-toggle="collapse"
                        href="#menuIbu"
                        role="button"
                        aria-expanded="false">
                        <span>
                            <i class="fa-solid fa-person-pregnant"></i>Ibu Hamil
                        </span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->routeIs($role.'.ibu.*') || request()->routeIs($role.'.pemeriksaan-ibu.*') ? 'show' : '' }}"
                        id="menuIbu">
                        <ul class="nav flex-column ms-4 mt-1 border-start ps-3">
                            <li>
                                <a href="{{ route($role.'.ibu.index') }}"
                                    class="sidebar-link">
                                    Data Ibu Hamil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route($role.'.ibu.pemeriksaan.create') }}"
                                    class=" sidebar-link">
                                    Pemeriksaan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if($role === 'admin')
                <li>
                    <a href="{{ route('admin.imunisasi.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.imunisasi.*') ? 'active' : '' }}">

                        <i class="fa-solid fa-syringe"></i>
                        Imunisasi
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">

                        <i class="bi bi-people-fill"></i>
                        Pegawai
                    </a>
                </li>

                <!-- section layanan -->
                <li class="sidebar-section">LAYANAN</li>
                <li>
                    <a href="{{ route('admin.layanan.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i>
                        Jadwal
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.edukasi.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.edukasi.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-medical"></i>
                        Edukasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengumuman.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i>
                        Pengumuman
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.komentar.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.komentar.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-dots"></i>
                        Komentar
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- sidebar desktop -->
    <div class="d-flex vh-100 overflow-hidden">
        <div class="d-none d-md-flex flex-column flex-shrink-0 px-4 py-3 bg-white border-end sidebar">
            <div href="#" class="d-flex align-items-center text-dark fw-bold pb-2 border-bottom">
                <img src="{{ asset('storage/images/Logo_Posyandu.png') }}"
                    alt=""
                    width="35"
                    height="35"
                    class="me-2">
                <div class="">
                    <span class="fs-5 fw-bold">{{ $role == 'admin' ? 'Admin' : 'Kader' }}</span>
                    <div class="text-muted" style="font-size: 11px;">SIMANDU</div>
                </div>
            </div>
            <ul class="nav flex-column">
                <!-- section main menu -->
                <li class="sidebar-section">MAIN MENU</li>
                <li>
                    <a href="{{ route($role.'.dashboard')}}"
                        class="sidebar-link {{ request()->routeIs($role.'.dashboard') ? 'active' : '' }}">

                        <i class="bi bi-house"></i>
                        Dashboard
                    </a>
                </li>

                <!-- section data master -->
                <li class="sidebar-section">DATA MASTER</li>
                <li>
                    <a class="sidebar-link d-flex justify-content-between align-items-center
                        {{ request()->routeIs($role.'.balita.*') || request()->routeIs($role.'.pemeriksaan-balita.*') ? 'active' : '' }}"
                        data-bs-toggle="collapse"
                        href="#menuBalita"
                        role="button"
                        aria-expanded="false">
                        <span>
                            <i class="fa-solid fa-baby"></i>Balita
                        </span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs($role.'.balita.*') || request()->routeIs($role.'.pemeriksaan-balita.*') ? 'show' : '' }}"
                        id="menuBalita">
                        <ul class="nav flex-column ms-4 mt-1 border-start ps-3">
                            <li>
                                <a href="{{ route($role.'.balita.index') }}"
                                    class="sidebar-link">
                                    Data Balita
                                </a>
                            </li>
                            <li>
                                <a href="{{ route($role.'.balita.pemeriksaan.create') }}"
                                    class="sidebar-link">
                                    Pemeriksaan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="sidebar-link d-flex justify-content-between align-items-center
                        {{ request()->routeIs($role.'.ibu.*') || request()->routeIs($role.'.pemeriksaan-ibu.*') ? 'active' : '' }}"
                        data-bs-toggle="collapse"
                        href="#menuIbu"
                        role="button"
                        aria-expanded="false">
                        <span>
                            <i class="fa-solid fa-person-pregnant"></i>Ibu Hamil
                        </span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->routeIs($role.'.ibu.*') || request()->routeIs($role.'.pemeriksaan-ibu.*') ? 'show' : '' }}"
                        id="menuIbu">
                        <ul class="nav flex-column ms-4 mt-1 border-start ps-3">
                            <li>
                                <a href="{{ route($role.'.ibu.index') }}"
                                    class="sidebar-link">
                                    Data Ibu Hamil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route($role.'.ibu.pemeriksaan.create') }}"
                                    class=" sidebar-link">
                                    Pemeriksaan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if($role === 'admin')
                <li>
                    <a href="{{ route('admin.imunisasi.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.imunisasi.*') ? 'active' : '' }}">

                        <i class="fa-solid fa-syringe"></i>
                        Imunisasi
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">

                        <i class="bi bi-people-fill"></i>
                        Pegawai
                    </a>
                </li>

                <!-- section layanan -->
                <li class="sidebar-section">LAYANAN</li>
                <li>
                    <a href="{{ route('admin.layanan.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i>
                        Jadwal
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.edukasi.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.edukasi.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-medical"></i>
                        Edukasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengumuman.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i>
                        Pengumuman
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.komentar.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.komentar.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-dots"></i>
                        Komentar
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <div class="flex-grow-1 d-flex flex-column overflow-hidden">
            <div class="topbar px-4 py-2 border-bottom">
                <div class="d-flex justify-content-between align-items-center">

                    <button class="btn btn-outline-primary d-md-none me-2"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#sidebarMobile">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="flex-grow-1">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 small">
                                @yield('page-breadcrumb')
                            </ol>
                        </nav>
                    </div>

                    <div class="dropdown">

                        <a href="#"
                            class="d-flex align-items-center text-decoration-none"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <img
                                src="{{ auth()->user()->foto 
                                ? asset('storage/' . auth()->user()->foto) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                alt="profile"
                                class="rounded-circle object-fit-cover border"
                                width="35"
                                height="35">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li class="px-3 py-2">
                                <div class="fw-bold">
                                    {{ auth()->user()->name }}
                                </div>

                                <small class="text-muted">
                                    {{ auth()->user()->email }}
                                </small>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="content px-4 py-4 overflow-auto flex-grow-1">
                @yield('content')
            </div>

        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables js -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- cdn js chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- cdn js chart.js plugin persenan -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>