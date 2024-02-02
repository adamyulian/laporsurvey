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
        Schema::create('surveykendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('tempat_duduk')->nullable();
            $table->string('dashboard')->nullable();
            $table->string('ac')->nullable();
            $table->string('kaca_film')->nullable();
            $table->string('toolkit')->nullable();
            $table->string('body')->nullable();
            $table->string('cat')->nullable();
            $table->string('lampu_utama')->nullable();
            $table->string('lampu_sein_depan')->nullable();
            $table->string('lampu_sein_blkg')->nullable();
            $table->string('lampu_rem')->nullable();
            $table->string('ban_mobil')->nullable();
            $table->string('ban_serep')->nullable();
            $table->string('klakson')->nullable();
            $table->string('wiper')->nullable();
            $table->string('spion')->nullable();
            $table->string('mesin')->nullable();
            $table->string('accu')->nullable();
            $table->string('rem')->nullable();
            $table->string('transmisi')->nullable();
            $table->string('power_steering')->nullable();
            $table->string('radiator')->nullable();
            $table->string('oli_mesin')->nullable();
            $table->string('gambar_interior')->nullable();
            $table->string('gambar_eksterior')->nullable();
            $table->string('gambar_mesin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveykendaraans');
    }
};
