<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKeluar; // Pastikan Model SuratKeluar sudah ada
use Illuminate\Support\Facades\Auth;

class SuratKeluarDivisiController extends Controller
{
public function index()
{
    $surats = SuratKeluar::whereHas('suratMasuk', function($query) {
        $query->where('id_admin', auth()->id());
    })
    ->orderBy('created_at', 'desc')
    ->get();

    // Karena file Anda ada di: resources/views/admindivisi/surat_keluar.blade.php
    return view('admindivisi.surat_keluar', compact('surats'));
}
    public function download($file)
    {
        $filePath = public_path('uploads/surat_keluar/' . $file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
}