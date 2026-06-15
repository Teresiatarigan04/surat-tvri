<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel surat_masuk
            $table->foreignId('surat_id')->constrained('surat_masuk')->onDelete('cascade');
            // Relasi ke tabel users (siapa yang ngirim)
            $table->foreignId('dari_admin')->constrained('users');
            // Relasi ke tabel users (siapa yang nerima - ADMINDIVISI)
            $table->foreignId('ke_admin')->constrained('users');
            
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'diproses', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};