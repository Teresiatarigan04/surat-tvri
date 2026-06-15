<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat_keluar = SuratKeluar::orderBy('created_at', 'desc')->get();
        $surat_tersedia = SuratMasuk::where('status', 'disetujui')
            ->whereDoesntHave('suratKeluar')
            ->get();

        // PERBAIKAN: Logika pembuatan nomor otomatis ($autoNumber) dihapus

        return view('adminsekret.surat_keluar', compact('surat_keluar', 'surat_tersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id'    => 'nullable|exists:surat_masuk,id',
            'no_surat_keluar'   => 'required|unique:surat_keluar,no_surat_keluar',
            'tujuan'            => 'required',
            'file_surat_final'  => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $perihal = 'Tanpa Perihal';
        if ($request->filled('surat_masuk_id')) {
            $suratMasuk = SuratMasuk::find($request->surat_masuk_id);
            $perihal = $suratMasuk ? $suratMasuk->perihal : $perihal;
        }

        $file = $request->file('file_surat_final');
        $fileName = time() . '_final_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/surat_keluar'), $fileName);

        SuratKeluar::create([
            'admin_sekret_id'   => Auth::id(),
            'surat_masuk_id'    => $request->surat_masuk_id,
            'no_surat_keluar'   => trim($request->no_surat_keluar), // Mengambil nilai input manual
            'perihal'           => $perihal,
            'tujuan'            => trim($request->tujuan),
            'tanggal_keluar'    => now(),
            'file_surat_final'  => $fileName,
            'status'            => 'terkirim',
        ]);

        $this->logAction($request, 'Menerbitkan surat keluar nomor: ' . $request->no_surat_keluar);

        return redirect()->back()->with('success', 'Surat keluar berhasil diterbitkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tujuan' => 'required',
            'status' => 'required|in:terkirim,arsip',
            'file_surat_final' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $surat = SuratKeluar::findOrFail($id);
        $noSurat = $surat->no_surat_keluar;

        $dataUpdate = [
            'tujuan' => trim($request->tujuan),
            'status' => $request->status,
        ];

        if ($request->hasFile('file_surat_final')) {
            $oldPath = public_path('uploads/surat_keluar/' . $surat->file_surat_final);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            $file = $request->file('file_surat_final');
            $fileName = time() . '_update_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/surat_keluar'), $fileName);
            $dataUpdate['file_surat_final'] = $fileName;
        }

        $surat->update($dataUpdate);

        $this->logAction($request, "Update data surat keluar No: $noSurat");

        return redirect()->back()->with('success', 'Data surat keluar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $noSurat = $surat->no_surat_keluar;

        $path = public_path('uploads/surat_keluar/' . $surat->file_surat_final);
        if (File::exists($path)) {
            File::delete($path);
        }

        $surat->delete();

        $this->logAction(request(), 'Menghapus arsip surat keluar nomor: ' . $noSurat);

        return redirect()->back()->with('success', 'Arsip surat keluar berhasil dihapus!');
    }

    private function logAction($request, $aktivitas)
    {
        LogActivity::create([
            'user_id'    => Auth::id(),
            'username'   => Auth::user()->username,
            'role'       => Auth::user()->role,
            'halaman'    => 'Surat Keluar',
            'aktivitas'  => $aktivitas,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
