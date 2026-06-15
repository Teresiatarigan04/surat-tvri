<?php

namespace App\Http\Controllers;

use App\Models\SuratSekret;
use App\Models\User;
use App\Models\LogActivity; // Import Model Log
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB; // Import DB Facade

class SuratSekretController extends Controller
{
    /**
     * Menampilkan daftar surat sekretariat.
     */
    public function index(): View
    {
        $adminDivisi = User::where('role', 'ADMINDIVISI')->get();
        $suratSekrets = SuratSekret::with('pengirim')->latest()->get();

        return view('adminsekret.kirim_surat', compact('adminDivisi', 'suratSekrets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'no_surat'   => 'required|unique:surat_sekrets,no_surat',
            'perihal'    => 'required|string|max:255',
            'tujuan_id'  => 'required|array|min:1',
            'file_surat' => 'required|mimes:pdf,doc,docx|max:1024',
        ]);

        try {
            DB::beginTransaction();

            $namaFile = null;
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $namaFile = 'SURAT_SEKRET_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/surat_sekret'), $namaFile);
            }

            SuratSekret::create([
                'id_admin_pengirim' => Auth::id(),
                'no_surat'          => $request->no_surat,
                'perihal'           => $request->perihal,
                'tujuan_id'         => $request->tujuan_id,
                'file_surat'        => $namaFile,
            ]);

            // CATAT LOG
            $this->logAction($request, 'Mengirim surat baru No: ' . $request->no_surat);

            DB::commit();
            return back()->with('success', 'Surat berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengirim surat: ' . $e->getMessage());
        }
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $surat = SuratSekret::findOrFail($id);

        $request->validate([
            'no_surat'   => 'required|unique:surat_sekrets,no_surat,' . $id,
            'perihal'    => 'required|string|max:255',
            'tujuan_id'  => 'required|array|min:1',
            'file_surat' => 'nullable|mimes:pdf,doc,docx|max:1024',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'no_surat'  => $request->no_surat,
                'perihal'   => $request->perihal,
                'tujuan_id' => $request->tujuan_id,
            ];

            if ($request->hasFile('file_surat')) {
                // Hapus file lama
                $oldPath = public_path('uploads/surat_sekret/' . $surat->file_surat);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }

                // Upload file baru
                $file = $request->file('file_surat');
                $namaFile = 'SURAT_SEKRET_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/surat_sekret'), $namaFile);

                $data['file_surat'] = $namaFile;
            }

            $surat->update($data);

            // CATAT LOG
            $this->logAction($request, 'Memperbarui data surat No: ' . $surat->no_surat);

            DB::commit();
            return back()->with('success', 'Data surat berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui surat: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $surat = SuratSekret::findOrFail($id);
            $nomorSurat = $surat->no_surat; // Simpan nomor untuk log

            // Hapus File
            $path = public_path('uploads/surat_sekret/' . $surat->file_surat);
            if (File::exists($path)) {
                File::delete($path);
            }

            $surat->delete();

            // CATAT LOG
            $this->logAction($request, 'Menghapus surat No: ' . $nomorSurat);

            DB::commit();
            return back()->with('success', 'Data surat berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus surat: ' . $e->getMessage());
        }
    }

    /**
     * Helper Function untuk mencatat aktivitas pengguna.
     * 
     * @param Request $request
     * @param string $aktivitas
     */
    private function logAction(Request $request, string $aktivitas): void
    {
        \App\Models\LogActivity::create([
            'user_id'    => \Illuminate\Support\Facades\Auth::id(),
            'username'   => \Illuminate\Support\Facades\Auth::user()->username,
            'role'       => \Illuminate\Support\Facades\Auth::user()->role,
            'halaman'    => 'Kirim Surat Sekretariat',
            'aktivitas'  => $aktivitas,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
