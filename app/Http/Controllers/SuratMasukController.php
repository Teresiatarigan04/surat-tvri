<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surat = SuratMasuk::orderBy('created_at', 'desc')->get();
        return view('adminsekret.surat_masuk', compact('surat'));
    }

   public function store(Request $request)
{
    $request->validate([
        'no_surat'      => 'required|unique:surat_masuk,no_surat',
        'pengirim'      => 'required',
        'perihal'       => 'required',
        'tanggal_surat' => 'required|date',
        'file_surat'    => 'required|mimes:pdf,doc,docx|max:5120',
        'sifat'         => 'required|in:penting,segera,rahasia',
    ]);

    $fileName = time() . '_sekret_' . $request->file('file_surat')->getClientOriginalName();
    

    $targetPath = base_path('public_html/uploads/surat_masuk');
    if (!file_exists($targetPath)) {
        $targetPath = public_path('uploads/surat_masuk');
    }
    
    // Pindahkan file ke target path yang sudah benar
    $request->file('file_surat')->move($targetPath, $fileName);
    // -------------------------------

    SuratMasuk::create([
        'id_admin'      => Auth::id(),
        'no_surat'      => trim($request->no_surat),
        'pengirim'      => trim($request->pengirim),
        'perihal'       => trim($request->perihal),
        'tanggal_surat' => $request->tanggal_surat,
        'sifat'         => $request->sifat,
        'file_surat'    => $fileName,
        'status'        => 'pending',
    ]);

    $this->logAction('Menambahkan surat masuk baru nomor: ' . $request->no_surat);

    return redirect()->back()->with('success', 'Arsip surat berhasil ditambahkan!');
}
    // Tambahkan fungsi ini di dalam SuratMasukController.php

    public function markAsRead($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        if (!$surat->is_read) {
            $surat->update(['is_read' => 1]);
            return response()->json(['success' => true, 'message' => 'Surat ditandai telah dibaca']);
        }
        return response()->json(['success' => true, 'message' => 'Surat sudah dibaca sebelumnya']);
    }

    public function update(Request $request, $id)
    {
        // Tetap divalidasi karena input readonly tetap mengirim data ke server
        $request->validate([
            'no_surat'      => 'required',
            'pengirim'      => 'required',
            'perihal'       => 'required',
            'tanggal_surat' => 'required|date',
            'sifat'         => 'required|in:penting,segera,rahasia',
            'status'        => 'required|in:pending,diproses,ditolak,disetujui',
        ]);

        $surat = SuratMasuk::findOrFail($id);
        $noSuratLama = $surat->no_surat;

        // Proses update (Data lain tetap diupdate dengan nilai yang sama/readonly tadi)
        $surat->update([
            'no_surat'      => trim($request->no_surat),
            'pengirim'      => trim($request->pengirim),
            'perihal'       => trim($request->perihal),
            'tanggal_surat' => $request->tanggal_surat,
            'sifat'         => $request->sifat,
            'status'        => $request->status,
        ]);

        $this->logAction("Update status surat No: $noSuratLama menjadi {$request->status}");

        return redirect()->back()->with('success', 'Status surat berhasil diperbarui!');
    }

    public function download($file)
    {
        $path = public_path('uploads/surat_masuk/' . $file);
        if (File::exists($path)) {
            return response()->download($path);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server.');
    }

    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $path = public_path('uploads/surat_masuk/' . $surat->file_surat);
        if (File::exists($path)) {
            File::delete($path);
        }
        $surat->delete();

        $this->logAction('Menghapus surat nomor: ' . $surat->no_surat);

        return redirect()->back()->with('success', 'Surat berhasil dihapus!');
    }

    // Helper log agar kode lebih bersih
    private function logAction($aktivitas)
    {
        LogActivity::create([
            'user_id'    => Auth::id(),
            'username'   => Auth::user()->username,
            'role'       => Auth::user()->role,
            'halaman'    => 'Surat Masuk',
            'aktivitas'  => $aktivitas,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
