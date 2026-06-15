<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('balasan_disposisi', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel disposisi induk
            $table->foreignId('disposisi_id')->constrained('disposisi')->onDelete('cascade');
            
            // Relasi ke surat masuk
            $table->foreignId('surat_id')->constrained('surat_masuk')->onDelete('cascade');
            
            // Siapa yang membalas (Admin Divisi)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->text('pesan_balasan')->nullable();
            $table->string('file_balasan'); // File PDF/Doc progres dari divisi
            
            // PERBAIKAN DI SINI: Ganti titik (.) menjadi panah (->)
            $table->enum('status_progres', ['proses', 'selesai'])->default('proses');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('balasan_disposisi');
    }
};