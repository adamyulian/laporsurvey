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
            $table->string('speedometer')->nullable();
            $table->string('kebersihan')->nullable();
            $table->string('ket_speedometer')->nullable();
            $table->string('ket_kebersihan')->nullable();
            $table->string('ket_tempat_duduk')->nullable();
            $table->string('ket_dashboard')->nullable();
            $table->string('ket_ac')->nullable();
            $table->string('ket_kaca_film')->nullable();
            $table->string('ket_toolkit')->nullable();
            $table->string('ket_body')->nullable();
            $table->string('ket_cat')->nullable();
            $table->string('ket_lampu_utama')->nullable();
            $table->string('ket_lampu_sein_depan')->nullable();
            $table->string('ket_lampu_sein_blkg')->nullable();
            $table->string('ket_lampu_rem')->nullable();
            $table->string('ket_ban_mobil')->nullable();
            $table->string('ket_ban_serep')->nullable();
            $table->string('ket_klakson')->nullable();
            $table->string('ket_wiper')->nullable();
            $table->string('ket_spion')->nullable();
            $table->string('ket_mesin')->nullable();
            $table->string('ket_accu')->nullable();
            $table->string('ket_rem')->nullable();
            $table->string('ket_transmisi')->nullable();
            $table->string('ket_power_steering')->nullable();
            $table->string('ket_radiator')->nullable();
            $table->string('ket_oli_mesin')->nullable();
            $table->string('gambar_speedometer')->nullable();
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
