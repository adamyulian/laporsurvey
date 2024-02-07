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
        Schema::table('surveykendaraans', function (Blueprint $table) {
            $table->float('kilometer')->nullable();
            $table->string('merk_ban')->nullable();
            $table->string('tahun_ban')->nullable();
            $table->string('merk_accu')->nullable();
            $table->string('masa_pajak')->nullable();
            $table->string('informasi_tambahan')->nullable();
            $table->string('lampu_kabut')->nullable();
            $table->string('lampu_mundur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveykendaraans', function (Blueprint $table) {
            //
        });
    }
};
