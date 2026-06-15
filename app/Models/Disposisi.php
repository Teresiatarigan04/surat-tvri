<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi plural (disposisis)
    protected $table = 'disposisi';

    protected $fillable = [
        'surat_id',
        'dari_admin',
        'ke_admin',
        'catatan',
        'file_disposisi',
        'status',
        'peran',       // Tambahkan ini
        'ketua_tim',   // Tambahkan ini
    ];
    // App\Models\Disposisi.php
    public function surat()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'ke_admin');
    }

    public function dariAdmin()
    {
        return $this->belongsTo(User::class, 'dari_admin');
    }

    public function balasan()
    {
        // Model BalasanDisposisi sekarang sudah bisa dikenali
        return $this->hasOne(BalasanDisposisi::class, 'disposisi_id');
    }
}
