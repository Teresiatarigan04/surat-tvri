<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk'; // Menunjuk ke tabel surat_masuk
    protected $fillable = [
        'id_admin',
        'no_surat',
        'pengirim',
        'perihal',
        'tanggal_surat',
        'sifat',
        'file_surat',
        'status',
        'is_read', // <-- PASTIKAN BARIS INI ADA
    ];

    public function disposisis()
    {
        // Jika di tabel disposisi kolomnya bernama 'surat_id', maka:
        return $this->hasMany(Disposisi::class, 'surat_id', 'id');

        /* 
       Catatan: Jika kolom di tabel disposisi Anda bernama 'id_surat', 
       maka ganti 'surat_id' menjadi 'id_surat'.
    */
    }

    // Di dalam class SuratMasuk
    public function suratKeluar()
    {
        return $this->hasOne(SuratKeluar::class, 'surat_masuk_id');
    }
}
