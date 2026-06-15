<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_sekrets', function (Blueprint $table) {
            $table->id();
            // ID Admin Sekretariat yang mengirim surat
            $table->unsignedBigInteger('id_admin_pengirim');
            
            // Detail Surat (Varchar length disamakan dengan surat_masuk)
            $table->string('no_surat', 100)->unique();
            $table->string('perihal', 255);
            
            // Kolom ini akan menyimpan ID para Admin Divisi dalam bentuk JSON (Array)
            // Contoh isi: ["2", "5", "8"]
            $table->text('tujuan_id'); 
            
            $table->string('file_surat', 255);
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('id_admin_pengirim')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_sekrets');
    }
};