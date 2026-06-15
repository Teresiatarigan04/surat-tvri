<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardSekretController extends Controller
{
    public function index()
    {
        // Statistik Surat Masuk
        $totalSuratMasuk = SuratMasuk::count();
        $suratMasukBaru = SuratMasuk::whereMonth('created_at', Carbon::now()->month)->count();

        // Statistik Surat Keluar
        $totalSuratKeluar = SuratKeluar::count();
        $suratKeluarBulanIni = SuratKeluar::whereMonth('tanggal_keluar', Carbon::now()->month)->count();

        // Statistik Disposisi
        $totalDisposisiPending = Disposisi::where('status', 'pending')->count();

        // Statistik User
        $userAktif = User::count();

        // Ambil 5 Aktivitas Terbaru (Gabungan atau Surat Masuk Terbaru)
        $riwayats = SuratMasuk::latest()->take(5)->get();
        // Di dalam fungsi index() DashboardSekretController.php
        $suratBelumDibaca = SuratMasuk::where('is_read', 0)->count();

        return view('adminsekret.dashboard', compact(
            'totalSuratMasuk',
            'suratMasukBaru',
            'totalSuratKeluar',
            'suratKeluarBulanIni',
            'totalDisposisiPending',
            'userAktif',
            'riwayats',
            'suratBelumDibaca' // Kirim variabel ke view
        ));
    }
}
