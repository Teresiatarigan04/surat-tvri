<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\LogActivity;
use App\Models\BalasanDisposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiDivisiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $disposisis = Disposisi::with(['surat', 'dariAdmin', 'balasan'])
            ->where('ke_admin', $user->id)
            ->latest()
            ->get();

        LogActivity::create([
            'user_id'    => $user->id,
            'username'   => $user->username ?? $user->name,
            'role'       => $user->type ?? 'ADMINDIVISI',
            'halaman'    => 'Disposisi Masuk',
            'aktivitas'  => 'Mengakses daftar disposisi masuk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return view('admindivisi.disposisi_masuk', compact('disposisis'));
    }

    /**
     * Mengupdate status alur penugasan kerja baru.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:disposisi,id',
            'status' => 'required|in:pending,diproses,sedang dilaksanakan,selesai dilaksanakan,sudah dibaca',
        ]);

        $user = Auth::user();
        $disposisi = Disposisi::findOrFail($request->id);
        $disposisi->status = $request->status;
        $disposisi->save();

        LogActivity::create([
            'user_id'    => $user->id,
            'username'   => $user->username ?? $user->name,
            'role'       => $user->type ?? 'ADMINDIVISI',
            'halaman'    => 'Disposisi Masuk',
            'aktivitas'  => "Mengubah status disposisi #" . $disposisi->id . " menjadi " . strtoupper($request->status),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Menggunakan session 'success' agar serasi dengan alert standar template
        // Ganti 'success' menjadi 'login_success'
        return back()->with('login_success', 'Status Berhasil Diperbarui!');
    }

    /**
     * Mengirim balasan laporan progres & otomatis menyelesaikan disposisi.
     */
    public function kirimBalasan(Request $request)
    {
        $request->validate([
            'disposisi_id' => 'required|exists:disposisi,id',
            'file_balasan' => 'nullable|mimes:pdf,doc,docx|max:1024',
            'pesan'        => 'required|string'
        ]);

        $user = Auth::user();
        $disposisi = Disposisi::findOrFail($request->disposisi_id);
        $fileName = null;

        if ($request->hasFile('file_balasan')) {
            $file = $request->file('file_balasan');
            $fileName = time() . '_balasan_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/balasan_disposisi'), $fileName);
        }

        // 1. Buat data balasan laporan kerja
        BalasanDisposisi::create([
            'disposisi_id'   => $disposisi->id,
            'surat_id'       => $disposisi->surat_id,
            'user_id'        => $user->id,
            'pesan_balasan'  => $request->pesan,
            'file_balasan'   => $fileName,
            'status_progres' => 'selesai',
        ]);

        // PERBAIKAN UTAMA: Otomatis ubah status induk disposisi menjadi selesai dilaksanakan
        $disposisi->status = 'selesai dilaksanakan';
        $disposisi->save();

        // 2. Catat Log aktivitas
        LogActivity::create([
            'user_id'    => $user->id,
            'username'   => $user->username ?? $user->name,
            'role'       => $user->type ?? 'ADMINDIVISI',
            'halaman'    => 'Disposisi Masuk',
            'aktivitas'  => "Mengirim laporan balasan untuk disposisi #" . $disposisi->id . " dan mengubah status menjadi SELESAI LAKSANA",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Menggunakan session 'success' agar dibaca oleh komponen alert view
        // Ganti 'success' menjadi 'login_success'
        return back()->with('login_success', 'Laporan Balasan Berhasil Terkirim dan Tugas Dinyatakan Selesai!');
    }
}
