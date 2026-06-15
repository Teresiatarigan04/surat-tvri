<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'surat_masuk_id',
        'admin_sekret_id', // Sesuaikan dengan struktur tabelmu
        'no_surat_keluar',
        'perihal',
        'tujuan',
        'tanggal_keluar',
        'file_surat_final',
        'status',
    ];

    // Relasi ke Surat Masuk (Opsional tapi berguna)
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }
}