<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratSekret extends Model
{
    use HasFactory;

    protected $table = 'surat_sekrets';

    protected $fillable = [
        'id_admin_pengirim',
        'no_surat',
        'perihal',
        'tujuan_id',
        'file_surat',
    ];

    // WAJIB: Memastikan tujuan_id selalu diperlakukan sebagai array
    protected $casts = [
        'tujuan_id' => 'array',
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_admin_pengirim');
    }
    // Tambahkan baris ini di dalam class SuratSekret
    public function pembaca()
    {
        return $this->belongsToMany(\App\Models\User::class, 'surat_sekret_user_read', 'surat_sekret_id', 'user_id')
            ->withTimestamps();
    }
}
