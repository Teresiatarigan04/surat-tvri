<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrackingDivisiController extends Controller
{
    private function recordActivity($aktivitas)
    {
        try {
            LogActivity::create([
                'user_id'    => Auth::id(),
                'username'   => Auth::user()->username ?? Auth::user()->nama,
                'role'       => Auth::user()->role,
                'halaman'    => 'Tracking Divisi',
                'aktivitas'  => $aktivitas,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal log TrackingDivisi: " . $e->getMessage());
        }
    }

    public function index()
    {
        $surats = SuratMasuk::where('id_admin', Auth::id())
            ->with(['disposisis.penerima'])
            ->latest()
            ->get();

        $disposisis = \App\Models\Disposisi::whereIn('surat_id', $surats->pluck('id'))
            ->with(['surat', 'penerima', 'dariAdmin'])
            ->get();

        $this->recordActivity('Melihat daftar tracking surat mandiri');

        return view('admindivisi.trackingsurat', compact('surats', 'disposisis'));
    }

    public function show($id)
    {
        try {
            // Memuat disposisi beserta relasi penerima, pembuat, dan balasan progresnya
            $surat = SuratMasuk::where('id_admin', Auth::id())
                ->with(['disposisis.penerima', 'disposisis.dariAdmin', 'disposisis.balasan'])
                ->findOrFail($id);

            $timeline = collect();

            // 1. REGISTRASI AWAL
            $timeline->push([
                'title'      => 'Registrasi Dokumen',
                'desc'       => "Surat dengan nomor {$surat->no_surat} telah diterima dan masuk ke dalam sistem.",
                'date'       => $surat->created_at,
                'status'     => 'REGISTERED',
                'icon'       => 'fa-file-import',
                'actor'      => 'Sistem Integrasi',
                'actor_role' => 'admin'
            ]);

            // 2. JEJAK DISPOSISI DAN PROGRES REAL-TIME
            foreach ($surat->disposisis as $disp) {
                $penerima = $disp->penerima->nama ?? 'Unit Kerja';
                $peranClean = strtolower($disp->peran ?? '');

                $keteranganTim = $disp->peran ?? 'Unit Kerja';
                if ($peranClean === 'pelaksana') {
                    $keteranganTim = !empty($disp->ketua_tim) ? "Pelaksana (Ketua Tim: {$disp->ketua_tim})" : 'Pelaksana Langsung';
                } elseif ($peranClean === 'pemantau') {
                    $keteranganTim = !empty($disp->ketua_tim) ? "Pemantau (Ketua Tim: {$disp->ketua_tim})" : 'Pemantau Langsung';
                }

                // Cek status berdasarkan database enum terbaru
                $statusDisposisi = strtolower($disp->status);

                if ($statusDisposisi === 'selesai dilaksanakan') {
                    $timelineStatus = 'SELESAI';
                    $descTimeline = "Tugas telah diselesaikan sepenuhnya oleh $penerima selaku $keteranganTim.";
                    $iconTimeline = 'fa-circle-check';
                } elseif ($statusDisposisi === 'sudah dibaca') {
                    $timelineStatus = 'PENDING';
                    $descTimeline = "Surat telah dibuka dan sedang diteliti/dianalisis oleh $penerima.";
                    $iconTimeline = 'fa-book-open';
                } else {
                    $timelineStatus = 'FORWARDED';
                    $descTimeline = "Surat didisposisikan kepada $penerima dan menunggu respon pembacaan.";
                    $iconTimeline = 'fa-paper-plane';
                }

                $timeline->push([
                    'title'      => "Disposisi: $penerima",
                    'desc'       => $descTimeline,
                    'date'       => $disp->updated_at ?? $disp->created_at,
                    'status'     => $timelineStatus,
                    'icon'       => $iconTimeline,
                    'peran'      => $disp->peran,
                    'ketua_tim'  => $disp->ketua_tim,
                    'actor'      => $penerima,
                    'actor_role' => 'divisi'
                ]);
            }

            // 3. MONITORING STATUS FINAL SURAT MASUK
            if (in_array(strtolower($surat->status), ['selesai', 'diarsip', 'disetujui'])) {
                $timeline->push([
                    'title'      => 'Arsip Selesai',
                    'desc'       => 'Seluruh tahapan disposisi selesai, berkas telah ditutup dan diarsipkan oleh Sekretariat.',
                    'date'       => $surat->updated_at,
                    'status'     => 'COMPLETED',
                    'icon'       => 'fa-box-archive',
                    'actor'      => $surat->dariAdmin->nama ?? 'Sekretariat',
                    'actor_role' => 'admin'
                ]);
            }

            return response()->json([
                'success'  => true,
                'surat'    => $surat,
                'timeline' => $timeline
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data detail timeline: ' . $e->getMessage()
            ], 500);
        }
    }
}
