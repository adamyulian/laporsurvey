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
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('register')->unique()->nullable();
            $table->string('luas')->nullable();
            $table->string('tahun_perolehan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('penggunaan')->nullable();
            $table->string('asal')->nullable();
            $table->string('surveyor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};
