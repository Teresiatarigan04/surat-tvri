<?php

// database/migrations/xxxx_xx_xx_create_tracking_surats_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tracking_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_id'); // Relasi ke surat_masuk
            $table->string('status'); // Contoh: 'Diterima', 'Disposisi', 'Selesai'
            $table->text('keterangan')->nullable();
            $table->string('lokasi_sekarang'); // Nama divisi atau posisi surat
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tracking_surat');
    }
};