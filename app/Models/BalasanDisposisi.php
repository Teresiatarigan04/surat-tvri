<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalasanDisposisi extends Model
{
    use HasFactory;

    protected $table = 'balasan_disposisi';

    protected $fillable = [
        'disposisi_id',
        'surat_id',
        'user_id',
        'pesan_balasan',
        'file_balasan',
        'status_progres',
    ];

    // Relasi ke SuratMasuk (Sudah ada)
    public function surat()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_id');
    }

    // TAMBAHKAN RELASI INI: Menghubungkan ke model Disposisi induknya
    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class, 'disposisi_id');
    }

    // OPSIONAL: Tambahkan juga relasi ke User (pengirim balasan jika dibutuhkan di view)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}