<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\LogActivity;
use App\Models\User; // <-- TAMBAHKAN INI UNTUK MENGAMBIL DATA EMAIL DARI DB
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PengajuanSuratBaruMail;
use Exception;

class AjukanSuratController extends Controller
{
    public function index()
    {
        return view('admindivisi.ajukan_surat');
    }

    public function riwayat()
    {
        $surats = SuratMasuk::where('id_admin', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admindivisi.riwayat', compact('surats'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'no_surat'      => 'required|unique:surat_masuk,no_surat',
            'pengirim'      => 'required',
            'perihal'       => 'required',
            'tanggal_surat' => 'required|date',
            'file_surat'    => 'required|mimes:pdf,doc,docx|max:1024',
        ], [
            // ... custom messages Anda
        ]);

        try {
            if ($request->hasFile('file_surat') && $request->file('file_surat')->isValid()) {

                $file = $request->file('file_surat');
                $originalName = str_replace(' ', '_', $file->getClientOriginalName());
                $fileName = time() . '_ajukan_' . $originalName;

                $file->move(public_path('uploads/surat_masuk'), $fileName);

                // Simpan data ke Database
                $surat = SuratMasuk::create([
                    'id_admin'      => Auth::id(),
                    'no_surat'      => $request->no_surat,
                    'pengirim'      => $request->pengirim,
                    'perihal'       => $request->perihal,
                    'tanggal_surat' => $request->tanggal_surat,
                    'sifat'         => $request->sifat,
                    'file_surat'    => $fileName,
                    'status'        => 'pending',
                ]);

                // Catat Aktivitas ke Log
                LogActivity::create([
                    'user_id'    => Auth::id(),
                    'username'   => Auth::user()->username,
                    'role'       => Auth::user()->role,
                    'halaman'    => 'Ajukan Surat',
                    'aktivitas'  => 'Melakukan pengajuan surat baru: ' . $request->no_surat,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                // --- PROSES KIRIM EMAIL OTOMATIS KE ADMIN SEKRET DARI DATABASE ---
                try {
                    // Mencari user yang memiliki role sekretariat di database
                    // Sesuaikan string 'sekretariat' dengan value role yang ada di DB Anda (misal: 'sekretariat', 'admin sekret', dll)
                    $adminSekret = User::where('role', 'sekretariat')->first();

                    if ($adminSekret && !empty($adminSekret->email)) {
                        $emailTarget = $adminSekret->email;
                    } else {
                        // Fallback/Cadangan jika data di DB tidak ditemukan, pakai email Kak Teresia langsung
                        $emailTarget = 'teresiatarigan557@gmail.com';
                    }

                    Mail::to($emailTarget)->send(new PengajuanSuratBaruMail($surat));
                } catch (Exception $mailException) {
                    // Log jika email gagal dikirim agar aplikasi tidak ikut crash
                    Log::error('Gagal mengirim email pengajuan baru: ' . $mailException->getMessage());
                }
                // --- END PROSES EMAIL ---

                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Pengajuan dokumen berhasil dikirim!']);
                }

                return back()->with('success', 'Pengajuan dokumen berhasil dikirim dan notifikasi email telah diteruskan ke Sekretariat!');
            }

            throw new Exception("File tidak valid atau gagal diunggah.");
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }
}
