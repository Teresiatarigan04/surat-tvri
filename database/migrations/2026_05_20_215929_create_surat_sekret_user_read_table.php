<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_sekret_user_read', function (Blueprint $table) {
            $table->id();
            // Sesuaikan nama field 'surat_sekret_id' dengan primary key tabel SuratSekret Anda
            $table->foreignId('surat_sekret_id')->constrained('surat_sekrets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Mencegah duplikasi data pembacaan
            $table->unique(['surat_sekret_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_sekret_user_read');
    }
};