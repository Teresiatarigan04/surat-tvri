<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity; // Import Model LogActivity
// Tambahkan ini di paling atas file LogActivity.php jika perlu
use App\Models\User;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan paginate dengan custom query string agar pagination dua tabel tidak bentrok
        $logsSekret = LogActivity::with('user')
            ->where('role', 'ADMINSEKRET')
            ->latest()
            ->paginate(10, ['*'], 'sekret_page');

        $logsDivisi = LogActivity::with('user')
            ->where('role', 'ADMINDIVISI')
            ->latest()
            ->paginate(10, ['*'], 'divisi_page');

        return view('adminsekret.logactivity', compact('logsSekret', 'logsDivisi'));
    }
}
