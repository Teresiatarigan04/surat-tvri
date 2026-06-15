<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingSurat extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'tracking_surat';

    // Kolom yang boleh diisi manual
    protected $fillable = [
        'surat_id',
        'status',
        'keterangan',
        'lokasi_sekarang',
    ];

    /**
     * Relasi Balik ke Surat Masuk
     * Setiap record tracking dimiliki oleh satu surat masuk
     */
    public function surat(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_id');
    }
}