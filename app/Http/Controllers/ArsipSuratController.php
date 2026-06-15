<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\SuratSekret;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArsipSuratController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::with(['disposisis.penerima', 'suratKeluar'])
            ->orderBy('created_at', 'DESC')
            ->get();

        $suratKeluar = SuratKeluar::orderBy('created_at', 'DESC')->get();

        // TAMBAHAN: Mengambil data dari table surat_sekrets
        $suratTerkirim = SuratSekret::with('pengirim')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('adminsekret.arsipsurat', compact('suratMasuk', 'suratKeluar', 'suratTerkirim'));
    }

    public function show($id)
    {
        try {
            // 1. Coba cari di Surat Masuk dahulu
            $surat = SuratMasuk::with(['disposisis.penerima', 'suratKeluar'])->find($id);
            $type = 'masuk';

            // 2. Jika tidak ada di Surat Masuk, cari di Surat Keluar
            if (!$surat) {
                $surat = SuratKeluar::find($id);
                $type = 'keluar';
            }

            // 3. TAMBAHAN: Jika tidak ada juga, cari di Surat Sekret (Terkirim)
            if (!$surat) {
                $surat = SuratSekret::with('pengirim')->findOrFail($id);
                $type = 'terkirim';
            }

            $timeline = [];
            if ($type === 'masuk') {
                $timeline[] = [
                    'title' => 'Surat Masuk Register',
                    'date' => $surat->created_at->format('d/m/Y H:i'),
                    'icon' => 'fa-file-import',
                    'desc' => "Diterima dari {$surat->pengirim}."
                ];

                foreach ($surat->disposisis as $disp) {
                    $timeline[] = [
                        'title' => 'Disposisi Unit',
                        'date' => $disp->created_at->format('d/m/Y H:i'),
                        'icon' => 'fa-share-nodes',
                        'desc' => "Diteruskan ke " . ($disp->penerima->nama ?? 'Unit') . ": " . $disp->catatan
                    ];
                }

                if ($surat->suratKeluar) {
                    $timeline[] = [
                        'title' => 'Arsip Final',
                        'date' => $surat->suratKeluar->created_at->format('d/m/Y H:i'),
                        'icon' => 'fa-box-archive',
                        'desc' => "Tuntas menjadi Surat Keluar No: " . $surat->suratKeluar->no_surat_keluar
                    ];
                }
            } elseif ($type === 'keluar') {
                $timeline[] = [
                    'title' => 'Pembuatan Surat Keluar',
                    'date' => $surat->created_at->format('d/m/Y H:i'),
                    'icon' => 'fa-paper-plane',
                    'desc' => "Ditujukan ke: {$surat->tujuan}"
                ];
            } else {
                // Timeline khusus untuk Surat Sekret / Terkirim
                $timeline[] = [
                    'title' => 'Surat Sekretariat Terkirim',
                    'date' => $surat->created_at->format('d/m/Y H:i'),
                    'icon' => 'fa-share-from-square',
                    'desc' => "Dikirim oleh: " . ($surat->pengirim->name ?? 'Admin Sekretariat')
                ];
            }

            return response()->json([
                'success' => true,
                'type' => $type,
                'surat' => $surat,
                'timeline' => $timeline
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($type, $id)
    {
        if ($type === 'masuk') {
            $surat = SuratMasuk::findOrFail($id);
            $nomorIdentitas = $surat->no_surat;
            $folder = 'surat_masuk';
        } elseif ($type === 'keluar') {
            $surat = SuratKeluar::findOrFail($id);
            $nomorIdentitas = $surat->no_surat_keluar;
            $folder = 'surat_keluar';
        } else {
            // TAMBAHAN: Untuk tipe terkirim (SuratSekret)
            $surat = SuratSekret::findOrFail($id);
            $nomorIdentitas = $surat->no_surat;
            $folder = 'surat_sekret'; // sesuaikan nama folder penyimpanan file Anda
        }

        // Menghapus file langsung dari folder public/uploads/...
        if ($surat->file_surat) {
            $filePath = public_path("uploads/{$folder}/" . $surat->file_surat);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $this->logAction(request(), "Menghapus permanen arsip surat $type nomor: $nomorIdentitas");

        $surat->delete();
        return redirect()->back()->with('success', 'Arsip berhasil dihapus permanently.');
    }

    /**
     * Log Action Helper
     */
    private function logAction(Request $request, $aktivitas)
    {
        try {
            if (Auth::check()) {
                LogActivity::create([
                    'user_id'    => Auth::id(),
                    'username'   => Auth::user()->username ?? Auth::user()->name ?? 'System',
                    'role'       => Auth::user()->role ?? 'ADMINSEKRET',
                    'halaman'    => 'Arsip Surat',
                    'aktivitas'  => $aktivitas,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("LogActivity Error: " . $e->getMessage());
        }
    }
}
