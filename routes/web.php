<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AjukanSuratController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\DisposisiSekretController;
use App\Http\Controllers\DisposisiDivisiController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratKeluarDivisiController;
use App\Http\Controllers\KelolaTrackingController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\TrackingDivisiController;
use App\Http\Controllers\DashboardDivisiController;
use App\Http\Controllers\DashboardSekretController;
use App\Http\Controllers\SuratSekretController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\SuratMasukDivisiController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.proses');

Route::middleware(['auth'])->group(function () {
    Route::get('ADMINSEKRET/dashboard', [DashboardSekretController::class, 'index'])
        ->name('admin.sekret.dashboard');
    Route::get('ADMINDIVISI/dashboard', [DashboardDivisiController::class, 'index'])->name('admin.divisi.dashboard');



    Route::middleware(['auth', 'user-access:ADMINSEKRET'])->group(function () {
        // List & Detail
        Route::get('/admin/surat-masuk', [SuratMasukController::class, 'index'])->name('admin.surat.masuk');

        // CRUD Actions
        Route::post('/adminsekret/surat-masuk/store', [SuratMasukController::class, 'store'])->name('admin.surat.masuk.store');
        Route::put('/adminsekret/surat-masuk/update/{id}', [SuratMasukController::class, 'update'])->name('admin.surat.masuk.update');
        Route::delete('/adminsekret/surat-masuk/destroy/{id}', [SuratMasukController::class, 'destroy'])->name('admin.surat.masuk.destroy');

        Route::post('/adminsekret/surat-masuk/{id}/read', [SuratMasukController::class, 'markAsRead'])->name('adminsekret.surat-masuk.read');

        // Download
        Route::get('/adminsekret/surat-masuk/download/{file}', [SuratMasukController::class, 'download'])->name('admin.surat.masuk.download');
    });

    // Pastikan rute ini berada di dalam group middleware auth agar aman
    Route::middleware(['auth', 'user-access:ADMINSEKRET'])->group(function () {

        // Menampilkan halaman daftar akun
        Route::get('/kelola-akun', [KelolaAkunController::class, 'index'])->name('kelola-akun.index');

        // Menambah akun baru
        Route::post('/kelola-akun/store', [KelolaAkunController::class, 'store'])->name('kelola-akun.store');

        // Memperbarui data akun (menggunakan method PUT/PATCH)
        Route::put('/kelola-akun/update/{id}', [KelolaAkunController::class, 'update'])->name('kelola-akun.update');

        // Menghapus akun (menggunakan method DELETE)
        Route::delete('/kelola-akun/destroy/{id}', [KelolaAkunController::class, 'destroy'])->name('kelola-akun.destroy');
    });

    // Grouping berdasarkan Authentication dan Role ADMINSEKRET
    Route::middleware(['auth', 'user-access:ADMINSEKRET'])->group(function () {

        // Menampilkan halaman utama Disposisi Sekretariat
        Route::get('/disposisi-sekretariat', [DisposisiSekretController::class, 'index'])
            ->name('admin.disposisi.index');

        // Proses simpan data disposisi baru
        Route::post('/disposisi-sekretariat/store', [DisposisiSekretController::class, 'store'])
            ->name('admin.disposisi.store');

        // Mengambil data detail disposisi (untuk Modal Show/Edit via AJAX/Alpine)

        Route::get('/disposisi-sekretariat/{id}', [DisposisiSekretController::class, 'show']);

        // Proses update data disposisi
        Route::put('/disposisi-sekretariat/{id}', [DisposisiSekretController::class, 'update'])
            ->name('admin.disposisi.update');

        // Proses hapus data disposisi
        // Proses hapus data disposisi
        Route::delete('/disposisi-sekretariat/{id}', [DisposisiSekretController::class, 'destroy'])
            ->name('admindivisi.disposisi.destroy'); // Tambahkan 'divisi' di sini
    });

    Route::patch('/disposisi-sekret/{id}/update-status', [DisposisiSekretController::class, 'updateStatus'])->name('adminsekret.disposisi.updateStatus');



    Route::middleware(['auth', 'user-access:ADMINSEKRET'])->group(function () {

        /*
    |--------------------------------------------------------------------------
    | Modul Surat Keluar (Sekretariat)
    |--------------------------------------------------------------------------
    */
        Route::prefix('surat-keluar')->group(function () {
            // Tampilan Tabel & Form
            Route::get('/', [SuratKeluarController::class, 'index'])->name('admin.surat.keluar');

            // Proses Data (CRUD)
            Route::post('/store', [SuratKeluarController::class, 'store'])->name('suratkeluar.store');
            Route::put('/update/{id}', [SuratKeluarController::class, 'update'])->name('suratkeluar.update');
            Route::delete('/delete/{id}', [SuratKeluarController::class, 'destroy'])->name('suratkeluar.destroy');
        });
    });

    Route::middleware(['auth', 'user-access:ADMINSEKRET'])->group(function () {

        // Tracking Routes
        Route::get('/admin-sekret/tracking', [KelolaTrackingController::class, 'index'])->name('admin.tracking.index');
        Route::get('/admin-sekret/tracking/{id}', [KelolaTrackingController::class, 'show'])->name('admin.tracking.show');
        Route::delete('/admin-sekret/tracking/{id}', [KelolaTrackingController::class, 'destroy'])->name('admin.tracking.destroy');
    });


    Route::prefix('ADMINSEKRET')->group(function () {
        // Halaman Utama Arsip
        Route::get('/arsip', [ArsipSuratController::class, 'index'])->name('admin.arsip.index');

        // API untuk Detail (Timeline) & Edit (JSON)
        Route::get('/arsip/{id}', [ArsipSuratController::class, 'show']);

        // Update Data
        Route::post('/arsip/update-masuk/{id}', [ArsipSuratController::class, 'update_masuk'])->name('admin.arsip.update_masuk');
        Route::post('/arsip/update-keluar/{id}', [ArsipSuratController::class, 'update_keluar'])->name('admin.arsip.update_keluar');

        // Delete Data
        Route::delete('/arsip/{type}/{id}', [ArsipSuratController::class, 'destroy'])->name('admin.arsip.destroy');
    });


    Route::middleware(['auth', 'user-access:ADMINSEKRET'])->group(function () {

        // Fitur Surat Sekretariat
        Route::get('/surat-sekretariat', [App\Http\Controllers\SuratSekretController::class, 'index'])
            ->name('admin.suratsekret.index');

        Route::post('/surat-sekretariat/store', [App\Http\Controllers\SuratSekretController::class, 'store'])
            ->name('admin.suratsekret.store');

        Route::put('/surat-sekretariat/{id}', [App\Http\Controllers\SuratSekretController::class, 'update'])
            ->name('admin.suratsekret.update');

        Route::delete('/surat-sekretariat/{id}', [App\Http\Controllers\SuratSekretController::class, 'destroy'])
            ->name('admin.suratsekret.destroy');
    });

    Route::middleware(['auth', 'user-access:ADMINDIVISI'])->group(function () {
        Route::get('/riwayat-pengajuan', [AjukanSuratController::class, 'riwayat'])->name('ajukan.riwayat');
        Route::get('/ajukan-surat', [AjukanSuratController::class, 'index'])->name('ajukan.index');
        Route::post('/ajukan-surat/store', [AjukanSuratController::class, 'store'])->name('ajukan.store');
    });


    Route::post('/surat-masuk-divisi/{id}/read', [SuratMasukDivisiController::class, 'markAsRead'])->name('surat-masuk.read');


    Route::middleware(['auth', 'user-access:ADMINDIVISI'])->group(function () {
        Route::get('/divisi/tracking', [TrackingDivisiController::class, 'index'])->name('divisi.tracking.index');
        Route::get('/divisi/tracking/{id}', [TrackingDivisiController::class, 'show'])->name('divisi.tracking.show');
    });

    // Pastikan sudah masuk dalam group middleware auth
    Route::middleware(['auth', 'user-access:ADMINDIVISI'])->group(function () {

        // Halaman utama daftar disposisi masuk
        Route::get('/admindivisi/disposisi-masuk', [DisposisiDivisiController::class, 'index'])
            ->name('admindivisi.disposisi.index');

        // Proses update status (Setujui/Tolak)
        Route::post('/admindivisi/disposisi/update', [DisposisiDivisiController::class, 'updateStatus'])
            ->name('admindivisi.disposisi.update');

        Route::post('/admindivisi/disposisi/update-status', [DisposisiDivisiController::class, 'updateStatus'])
            ->name('admindivisi.disposisi.updateStatus');

        Route::post('/admindivisi/disposisi/balas', [DisposisiDivisiController::class, 'kirimBalasan'])
            ->name('admindivisi.disposisi.balas');
    });

    // Route khusus Admin Divisi
    Route::middleware(['auth', 'user-access:ADMINDIVISI'])->group(function () {

        // Daftar Surat Keluar milik divisi ybs
        Route::get('/admindivisi/surat-keluar', [SuratKeluarDivisiController::class, 'index'])
            ->name('admindivisi.surat_keluar.index');

        // Download File Surat Keluar
        Route::get('/admindivisi/surat-keluar/download/{file}', [SuratKeluarDivisiController::class, 'download'])
            ->name('admindivisi.surat_keluar.download');
    });


    Route::middleware(['auth', 'user-access:ADMINDIVISI'])->group(function () {
        Route::get('/divisi/surat-masuk', [SuratMasukDivisiController::class, 'index'])->name('divisi.surat-masuk');
    });



    // Ubah dari admin.log-activity menjadi admin.log.index
    Route::get('/adminsekret/log-activity', [LogActivityController::class, 'index'])->name('admin.log.index');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
