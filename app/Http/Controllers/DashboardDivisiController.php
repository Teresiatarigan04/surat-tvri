<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\Disposisi; 
use App\Models\SuratSekret; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardDivisiController extends Controller
{
    public function index()
    {
        $adminId = Auth::id(); 

        $stats = [
            'total_bulan_ini' => SuratMasuk::where('id_admin', $adminId)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),

            'sedang_diproses' => SuratMasuk::where('id_admin', $adminId)
                ->whereIn('status', ['pending', 'diproses'])
                ->count(),

            'disetujui'       => SuratMasuk::where('id_admin', $adminId)
                ->where('status', 'disetujui')
                ->count(),

            'surat_masuk'     => SuratSekret::whereJsonContains('tujuan_id', (string)$adminId)->count(),

            'disposisi_masuk' => Disposisi::where('ke_admin', $adminId)->count(),
        ];

        $riwayats = SuratMasuk::where('id_admin', $adminId)
            ->latest()
            ->take(5)
            ->get();

        // LOGIKA BARU: Ambil 1 surat TERBARU yang BELUM diklik detail oleh user ini
        $surat_baru_masuk = SuratSekret::whereJsonContains('tujuan_id', (string)$adminId)
            ->whereDoesntHave('pembaca', function($query) use ($adminId) {
                $query->where('user_id', $adminId);
            })
            ->latest()
            ->first();

        // HITUNG JUMLAH SURAT YANG BELUM DIKLIK DETAIL (BELUM DIBACA)
        $jumlah_terbaru = 0;
        if ($surat_baru_masuk) {
            $jumlah_terbaru = SuratSekret::whereJsonContains('tujuan_id', (string)$adminId)
                ->whereDoesntHave('pembaca', function($query) use ($adminId) {
                    $query->where('user_id', $adminId);
                })
                ->count();
        }

        return view('admindivisi.dashboard', compact('stats', 'riwayats', 'surat_baru_masuk', 'jumlah_terbaru'));
    }
}