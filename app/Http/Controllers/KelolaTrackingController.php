<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelolaTrackingController extends Controller
{
    /**
     * Helper untuk mencatat log activity secara otomatis.
     */
    private function recordActivity($aktivitas)
    {
        try {
            if (Auth::check()) {
                LogActivity::create([
                    'user_id'    => Auth::id(),
                    'username'   => Auth::user()->username ?? Auth::user()->name ?? 'Unknown',
                    'role'       => Auth::user()->role ?? 'Admin',
                    'halaman'    => 'Kelola Tracking',
                    'aktivitas'  => $aktivitas,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Gagal mencatat log di KelolaTracking: " . $e->getMessage());
        }
    }

    public function index()
    {
        // Ambil data disposisi diurutkan dari yang paling lama/awal ke terbaru agar tampilannya runut
        $surats = SuratMasuk::with(['disposisis' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'disposisis.penerima'])->latest()->get();

        $this->recordActivity('Membuka daftar tracking surat');

        return view('adminsekret.kelola_tracking', compact('surats'));
    }

    public function show($id)
    {
        try {
            $surat = SuratMasuk::with([
                'disposisis.penerima',
                'disposisis.dariAdmin'
            ])->findOrFail($id);

            $suratKeluar = \App\Models\SuratKeluar::where('surat_masuk_id', $id)->first();
            $timeline = collect();

            // 1. Fase AWAL
            $timeline->push([
                'type' => 'start',
                'title' => 'Surat Masuk Terdaftar',
                'desc' => "Diterima dari: {$surat->pengirim}",
                'date' => $surat->created_at,
                'status' => $surat->status,
                'icon' => 'fa-file-import',
                'peran' => null,
                'ketua_tim' => null
            ]);

            // 2. Fase PROSES
            foreach ($surat->disposisis as $disp) {
                $timeline->push([
                    'type' => 'disposisi',
                    'title' => "Disposisi: " . ($disp->penerima->nama ?? 'Unit Terkait'),
                    'desc' => "Instruksi: " . ($disp->catatan ?? 'Teruskan'),
                    'date' => $disp->created_at,
                    'status' => $disp->status,
                    'sender' => $disp->dariAdmin->nama ?? 'Sistem',
                    'icon' => 'fa-share-nodes',
                    'peran' => $disp->peran, // Diambil dari field database Anda
                    'ketua_tim' => $disp->ketua_tim // Diambil dari field database Anda
                ]);
            }

            // 3. Fase AKHIR
            if ($suratKeluar) {
                $timeline->push([
                    'type' => 'end',
                    'title' => 'Surat Selesai / Keluar',
                    'desc' => "No Keluar: {$suratKeluar->no_surat_keluar} - Tujuan: {$suratKeluar->tujuan}",
                    'date' => $suratKeluar->created_at,
                    'status' => 'SELESAI',
                    'icon' => 'fa-check-double',
                    'peran' => null,
                    'ketua_tim' => null
                ]);
            }

            $this->recordActivity("Melihat detail tracking surat: {$surat->no_surat}");

            return response()->json([
                'surat' => $surat,
                'timeline' => $timeline->sortBy('date')->values()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
