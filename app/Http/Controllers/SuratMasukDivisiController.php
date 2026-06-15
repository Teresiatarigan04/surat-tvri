<?php

namespace App\Http\Controllers;

use App\Models\SuratSekret;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SuratMasukDivisiController extends Controller
{
    public function index(Request $request): View
    {
        $userId = Auth::id();

        // Tambahkan with('pembaca') agar sistem tahu user mana saja yang sudah klik detail
        $suratMasuk = SuratSekret::with(['pengirim', 'pembaca'])
            ->whereJsonContains('tujuan_id', (string)$userId)
            ->latest()
            ->get();

        $stats = [
            'total' => $suratMasuk->count(),
            'hari_ini' => $suratMasuk->where('created_at', '>=', now()->startOfDay())->count(),
        ];

        $this->logAction($request, 'Membuka halaman Surat Masuk');

        return view('admindivisi.surat_masuk', compact('suratMasuk', 'stats'));
    }

    /**
     * API Endpoint: Menandai surat telah dibaca (Dipicu AJAX saat klik tombol mata)
     */
    public function markAsRead($id)
    {
        $surat = SuratSekret::findOrFail($id);
        $userId = Auth::id();

        // Catat ke tabel pivot pembaca jika belum ada
        $surat->pembaca()->syncWithoutDetaching([$userId]);

        return response()->json([
            'status' => 'success',
            'message' => 'Surat ditandai telah dilihat.'
        ]);
    }

    private function logAction(Request $request, string $aktivitas): void
    {
        LogActivity::create([
            'user_id'    => Auth::id(),
            'username'   => Auth::user()->username,
            'role'       => Auth::user()->role,
            'halaman'    => 'Surat Masuk Divisi',
            'aktivitas'  => $aktivitas,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}