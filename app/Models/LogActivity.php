<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = 'log_activities';

    protected $fillable = [
        'user_id',
        'username',
        'role',
        'halaman',
        'aktivitas',
        'ip_address',
        'user_agent',
    ];

    // TAMBAHKAN INI: Memastikan created_at dianggap sebagai objek tanggal (Carbon)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
