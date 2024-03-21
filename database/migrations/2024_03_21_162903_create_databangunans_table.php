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
        Schema::create('databangunans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_lokasi')->nullable();
            $table->string('register_bangunan')->nullable();
            $table->string('register_tanah')->nullable();
            $table->string('nama_bangunan')->nullable();
            $table->string('alamat_bangunan')->nullable();
            $table->string('kode_barang')->nullable();
            $table->string('luas_lantai')->nullable();
            $table->string('luas_bangunan')->nullable();
            $table->string('tahun_perolehan')->nullable();
            $table->string('nilai')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databangunans');
    }
};
