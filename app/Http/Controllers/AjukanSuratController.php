<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
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
            'no_surat.required'      => 'Nomor surat wajib diisi.',
            'no_surat.unique'        => 'Nomor surat sudah terdaftar di sistem.',
            'pengirim.required'      => 'Nama pengirim wajib diisi.',
            'perihal.required'       => 'Perihal surat wajib diisi.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'tanggal_surat.date'     => 'Format tanggal surat tidak valid.',
            'file_surat.required'    => 'File surat wajib diunggah.',
            'file_surat.max'         => 'Ukuran file terlalu besar. Maksimal adalah 1 MB.',
            'file_surat.mimes'       => 'Format file harus PDF, DOC, atau DOCX.',
        ]);

        try {
            // Pastikan ada file yang diunggah sebelum memproses
            if ($request->hasFile('file_surat') && $request->file('file_surat')->isValid()) {
                
                $file = $request->file('file_surat');
                // Membersihkan nama file asli dari karakter aneh/spasi berlebih
                $originalName = str_replace(' ', '_', $file->getClientOriginalName());
                $fileName = time() . '_ajukan_' . $originalName;

                // Simpan file ke folder public/uploads/surat_masuk
                $file->move(public_path('uploads/surat_masuk'), $fileName);

                // Simpan data ke Database
                SuratMasuk::create([
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

                // Antisipasi jika Frontend mengirim via AJAX/Fetch
                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Pengajuan dokumen berhasil dikirim!']);
                }

                return back()->with('success', 'Pengajuan dokumen (PDF/Word) berhasil dikirim!');
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