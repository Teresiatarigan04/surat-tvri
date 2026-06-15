<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('surat_keluar', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('surat_masuk_id')->nullable();
        $table->unsignedBigInteger('admin_sekret_id'); // ID kamu sebagai admin sekret
        $table->string('no_surat_keluar')->unique();
        $table->string('perihal');
        $table->string('tujuan');
        $table->date('tanggal_keluar');
        $table->string('file_surat_final');
        $table->enum('status', ['terkirim', 'arsip'])->default('terkirim');
        $table->timestamps();

        $table->foreign('surat_masuk_id')->references('id')->on('surat_masuk')->onDelete('set null');
        $table->foreign('admin_sekret_id')->references('id')->on('users');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
