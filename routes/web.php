<?php

use App\Http\Controllers\BalitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\IbuHamilController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengumumanController;
use Illuminate\Support\Facades\Route;

Route::controller(LandingPageController::class)->group(function () {
    Route::get('/', 'index')->name('landing');
    Route::get('/pengumuman', 'pengumuman')->name('landing.pengumuman');
    Route::get('/pengumuman/{id}', 'pengumuman_detail')->name('landing.pengumuman_detail');
    Route::get('/jadwal', 'jadwal')->name('landing.jadwal');
    Route::get('/edukasi/{id}', 'edukasi')->name('landing.edukasi');
    Route::post('/kirim_komentar', 'kirim_komentar')->name('landing.kirim_komentar');
    Route::get('/komentar/load', 'load_komentar')->name('landing.load_komentar');
});

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

// admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    // balita
    Route::controller(BalitaController::class)->group(function () {
        Route::get('/balita', 'index')->name('admin.balita.index');
        Route::get('/balita/create', 'create')->name('admin.balita.create');
        Route::post('/balita/store', 'store')->name('admin.balita.store');
        Route::delete('/balita/destroy/{id}', 'destroy')->name('admin.balita.destroy');
        Route::get('/balita/edit/{id}', 'edit')->name('admin.balita.edit');
        Route::put('/balita/update/{id}', 'update')->name('admin.balita.update');
        Route::get('/balita/view/{id}', 'view')->name('admin.balita.view');
        Route::get('/balita/export', 'export')->name('admin.balita.export');

        Route::get('/balita/pemeriksaan/create', 'create_pemeriksaan')->name('admin.balita.pemeriksaan.create');
        Route::post('/balita/pemeriksaan/store', 'store_pemeriksaan')->name('admin.balita.pemeriksaan.store');
        Route::get('/balita/pemeriksaan/edit/{id}', 'edit_pemeriksaan')->name('admin.balita.pemeriksaan.edit');
        Route::put('/balita/pemeriksaan/update/{id}', 'update_pemeriksaan')->name('admin.balita.pemeriksaan.update');
        Route::delete('/balita/pemeriksaan/destroy/{id}', 'destroy_pemeriksaan')->name('admin.balita.pemeriksaan.destroy');
    });

    // ibu hamil
    Route::controller(IbuHamilController::class)->group(function () {
        Route::get('/ibuhamil', 'index')->name('admin.ibu.index');
        Route::get('/ibuhamil/create', 'create')->name('admin.ibu.create');
        Route::post('/ibuhamil/store', 'store')->name('admin.ibu.store');
        Route::delete('/ibuhamil/destroy/{id}', 'destroy')->name('admin.ibu.destroy');
        Route::get('/ibuhamil/edit/{id}', 'edit')->name('admin.ibu.edit');
        Route::put('/ibuhamil/update/{id}', 'update')->name('admin.ibu.update');
        Route::get('/ibuhamil/view/{id}', 'view')->name('admin.ibu.view');
        Route::get('/ibuhamil/export', 'export')->name('admin.ibu.export');

        Route::get('/ibuhamil/pemeriksaan/create', 'create_pemeriksaan')->name('admin.ibu.pemeriksaan.create');
        Route::post('/ibuhamil/pemeriksaan/store', 'store_pemeriksaan')->name('admin.ibu.pemeriksaan.store');
        Route::get('/ibuhamil/pemeriksaan/edit/{id}', 'edit_pemeriksaan')->name('admin.ibu.pemeriksaan.edit');
        Route::put('/ibuhamil/pemeriksaan/update/{id}', 'update_pemeriksaan')->name('admin.ibu.pemeriksaan.update');

        Route::get('/ibuhamil/tensi/create', 'create_tensi')->name('admin.ibu.tensi.create');
        Route::post('/ibuhamil/tensi/store', 'store_tensi')->name('admin.ibu.tensi.store');
        Route::put('/ibuhamil/tensi/{id}', 'update_tensi')->name('admin.ibu.tensi.update');
        Route::delete('/ibuhamil/tensi/{id}', 'destroy_tensi')->name('admin.ibu.tensi.destroy');
    });

    // imunisasi
    Route::controller(ImunisasiController::class)->group(function () {
        Route::get('/imunisasi', 'index')->name('admin.imunisasi.index');
        Route::post('/imunisasi', 'store')->name('admin.imunisasi.store');
        Route::put('/imunisasi/{id}', 'update')->name('admin.imunisasi.update');
        Route::delete('/imunisasi/destroy/{id}', 'destroy')->name('admin.imunisasi.destroy');
    });

    // pegawai
    Route::controller(PegawaiController::class)->group(function () {
        Route::get('/pegawai', 'index')->name('admin.pegawai.index');
        Route::get('/pegawai/create', 'create')->name('admin.pegawai.create');
        Route::post('/pegawai/store', 'store')->name('admin.pegawai.store');
        Route::delete('/pegawai/destroy/{id}', 'destroy')->name('admin.pegawai.destroy');
        Route::get('/pegawai/edit/{id}', 'edit')->name('admin.pegawai.edit');
        Route::put('/pegawai/update/{id}', 'update')->name('admin.pegawai.update');
        Route::get('/pegawai/view/{id}', 'view')->name('admin.pegawai.view');
    });

    // jadwal
    Route::controller(JadwalController::class)->group(function () {
        Route::get('/layanan', 'index')->name('admin.layanan.index');
        Route::get('/layanan/create', 'create')->name('admin.layanan.create');
        Route::post('/layanan/store', 'store')->name('admin.layanan.store');
        Route::delete('/layanan/destroy/{id}', 'destroy')->name('admin.layanan.destroy');
        Route::get('/layanan/edit/{id}', 'edit')->name('admin.layanan.edit');
        Route::put('/layanan/update/{id}', 'update')->name('admin.layanan.update');
        Route::get('/layanan/view/{id}', 'view')->name('admin.layanan.view');
        Route::post('/layanan/status/{id}', 'change_status')->name('admin.layanan.change_status');
    });

    // pengumuman
    Route::controller(PengumumanController::class)->group(function () {
        Route::get('/pengumuman', 'index')->name('admin.pengumuman.index');
        Route::get('/pengumuman/create', 'create')->name('admin.pengumuman.create');
        Route::get('/pengumuman/edit/{id}', 'edit')->name('admin.pengumuman.edit');
        Route::post('/pengumuman', 'store')->name('admin.pengumuman.store');
        Route::put('/pengumuman/{id}', 'update')->name('admin.pengumuman.update');
        Route::delete('/pengumuman/destroy/{id}', 'destroy')->name('admin.pengumuman.destroy');
        Route::post('/pengumuman/status/{id}', 'change_status')->name('admin.pengumuman.change_status');

        Route::post('/ckeditor/upload', 'upload')->name('ckeditor.upload');
    });

    // edukasi
    Route::controller(EdukasiController::class)->group(function () {
        Route::get('/edukasi', 'index')->name('admin.edukasi.index');
        Route::post('/edukasi', 'store')->name('admin.edukasi.store');
        Route::get('/edukasi/edit/{id}', 'edit')->name('admin.edukasi.edit');
        Route::put('/edukasi/{id}', 'update')->name('admin.edukasi.update');
        Route::delete('/edukasi/{id}', 'destroy')->name('admin.edukasi.destroy');
    });

    // komentar
    Route::controller(KomentarController::class)->group(function () {
        Route::get('/komentar', 'index')->name('admin.komentar.index');
        Route::put('/komentar/balas/{id}', 'balas')->name('admin.komentar.balas');
        Route::delete('/komentar/balas/delete/{id}', 'hapusBalasan')->name('admin.komentar.hapus_balasan');
        Route::delete('/komentar/destroy/{id}', 'destroy')->name('admin.komentar.destroy');
    });
});

// kader
Route::prefix('kader')->middleware(['auth', 'role:kader'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('kader.dashboard');
    });

    // balita
    Route::controller(BalitaController::class)->group(function () {
        Route::get('/balita', 'index')->name('kader.balita.index');
        Route::get('/balita/create', 'create')->name('kader.balita.create');
        Route::post('/balita/store', 'store')->name('kader.balita.store');
        Route::delete('/balita/destroy/{id}', 'destroy')->name('kader.balita.destroy');
        Route::get('/balita/edit/{id}', 'edit')->name('kader.balita.edit');
        Route::put('/balita/update/{id}', 'update')->name('kader.balita.update');
        Route::get('/balita/view/{id}', 'view')->name('kader.balita.view');
        Route::get('/balita/export', 'export')->name('kader.balita.export');

        Route::get('/balita/pemeriksaan/create', 'create_pemeriksaan')->name('kader.balita.pemeriksaan.create');
        Route::post('/balita/pemeriksaan/store', 'store_pemeriksaan')->name('kader.balita.pemeriksaan.store');
        Route::get('/balita/pemeriksaan/edit/{id}', 'edit_pemeriksaan')->name('kader.balita.pemeriksaan.edit');
        Route::put('/balita/pemeriksaan/update/{id}', 'update_pemeriksaan')->name('kader.balita.pemeriksaan.update');
        Route::delete('/balita/pemeriksaan/destroy/{id}', 'destroy_pemeriksaan')->name('kader.balita.pemeriksaan.destroy');
    });

    // ibu hamil
    Route::controller(IbuHamilController::class)->group(function () {
        Route::get('/ibuhamil', 'index')->name('kader.ibu.index');
        Route::get('/ibuhamil/create', 'create')->name('kader.ibu.create');
        Route::post('/ibuhamil/store', 'store')->name('kader.ibu.store');
        Route::delete('/ibuhamil/destroy/{id}', 'destroy')->name('kader.ibu.destroy');
        Route::get('/ibuhamil/edit/{id}', 'edit')->name('kader.ibu.edit');
        Route::put('/ibuhamil/update/{id}', 'update')->name('kader.ibu.update');
        Route::get('/ibuhamil/view/{id}', 'view')->name('kader.ibu.view');
        Route::get('/ibuhamil/export', 'export')->name('kader.ibu.export');

        Route::get('/ibuhamil/pemeriksaan/create', 'create_pemeriksaan')->name('kader.ibu.pemeriksaan.create');
        Route::post('/ibuhamil/pemeriksaan/store', 'store_pemeriksaan')->name('kader.ibu.pemeriksaan.store');
        Route::get('/ibuhamil/pemeriksaan/edit/{id}', 'edit_pemeriksaan')->name('kader.ibu.pemeriksaan.edit');
        Route::put('/ibuhamil/pemeriksaan/update/{id}', 'update_pemeriksaan')->name('kader.ibu.pemeriksaan.update');

        Route::get('/ibuhamil/tensi/create', 'create_tensi')->name('kader.ibu.tensi.create');
        Route::post('/ibuhamil/tensi/store', 'store_tensi')->name('kader.ibu.tensi.store');
        Route::put('/ibuhamil/tensi/{id}', 'update_tensi')->name('kader.ibu.tensi.update');
        Route::delete('/ibuhamil/tensi/{id}', 'destroy_tensi')->name('kader.ibu.tensi.destroy');
    });
});

Route::get('/sitemap.xml', [LandingPageController::class, 'sitemap']);