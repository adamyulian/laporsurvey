<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('target2s', function (Blueprint $table) {
            $table->id();
            $table->string('nopol')->nullable();
            $table->string('tahun')->nullable();
            $table->string('merk')->nullable();
            $table->string('tipe')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('opd')->nullable();
            $table->foreignIdFor(Team::class)->nullable();
            $table->string('nama_penyelia')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target2s');
    }
};
