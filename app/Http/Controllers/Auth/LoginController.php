<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LogActivity;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Cek Login menggunakan Auth::attempt
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            $user = Auth::user();

            // 3. Catat Log Activity: LOGIN
            LogActivity::create([
                'user_id'    => $user->id,
                'username'   => $user->username,
                'role'       => $user->role,
                'halaman'    => 'Login',
                'aktivitas'  => 'User berhasil masuk ke sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // 4. Redirect Sesuai Role + Kirim Flash Session 'login_success'
            if ($user->role === 'ADMINSEKRET') {
                return redirect()->route('admin.sekret.dashboard')->with('login_success', true);
            } 
            
            if ($user->role === 'ADMINDIVISI') {
                return redirect()->route('admin.divisi.dashboard')->with('login_success', true);
            }
        }

        // 5. Jika Gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            LogActivity::create([
                'user_id'    => $user->id,
                'username'   => $user->username,
                'role'       => $user->role,
                'halaman'    => 'Logout',
                'aktivitas'  => 'User keluar dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}