<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_admin'); // Siapa yang menginput (Admin Sekret)
            $table->string('no_surat', 100)->unique();
            $table->string('pengirim', 150);
            $table->string('perihal', 255);
            $table->date('tanggal_surat');
            $table->enum('sifat', ['penting', 'segera', 'rahasia']);
            $table->string('file_surat', 255);
            $table->enum('status', ['pending', 'diproses', 'ditolak', 'disetujui'])->default('pending');
            
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    public function down(): void {
        Schema::dropIfExists('surat_masuk');
    }
};