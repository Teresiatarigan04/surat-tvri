<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadToSuratMasukTable extends Migration
{
    public function up()
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->integer('is_read')->default(0)->after('status');
        });
    }

    public function down()
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
}
