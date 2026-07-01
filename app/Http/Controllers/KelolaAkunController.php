<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KelolaAkunController extends Controller
{
    public function index()
    {
        $adminDivisi = User::where('role', 'ADMINDIVISI')->get();
        $adminSekret = User::where('role', 'ADMINSEKRET')->get();
        
        // Perbaikan: compact menggunakan nama variabel sebagai string
        return view('adminsekret.kelola_akun', compact('adminDivisi', 'adminSekret'));
    }

    public function store(Request $request)
    {
        // Menambahkan validasi untuk email
        $request->validate([
            'username' => 'required|unique:users,username',
            'email'    => 'required',
            'nama'     => 'required',
            'password' => 'required|min:6',
            'role'     => 'required'
        ]);

        // Menyisipkan email saat membuat user baru
        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'nama'     => $request->nama,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        LogActivity::create([
            'user_id'    => Auth::id(),
            'username'   => Auth::user()->username,
            'role'       => Auth::user()->role,
            'halaman'    => 'Kelola Akun',
            'aktivitas'  => 'Menambah user baru: ' . $request->username . ' sebagai ' . $request->role,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Menambahkan validasi email, ignore unique untuk id user yang sedang diupdate
        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'email'    => 'required',
            'nama'     => 'required',
            'role'     => 'required'
        ]);

        // Memasukkan email ke dalam array data yang akan diupdate
        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'nama'     => $request->nama,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogActivity::create([
            'user_id'    => Auth::id(),
            'username'   => Auth::user()->username,
            'role'       => Auth::user()->role,
            'halaman'    => 'Kelola Akun',
            'aktivitas'  => 'Mengubah data user: ' . $user->username,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $username = $user->username;
        $user->delete();

        LogActivity::create([
            'user_id'    => Auth::id(),
            'username'   => Auth::user()->username,
            'role'       => Auth::user()->role,
            'halaman'    => 'Kelola Akun',
            'aktivitas'  => 'Menghapus user: ' . $username,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}