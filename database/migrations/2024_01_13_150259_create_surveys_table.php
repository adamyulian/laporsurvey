<?php

use App\Models\Target;
use App\Models\User;
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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Target::class);
            $table->foreignIdFor(User::class);
            $table->boolean('status');
            $table->string('nama')->nullable();
            $table->string('foto')->nullable();
            $table->string('nama_pic')->nullable();
            $table->string('no_hp_pic')->nullable();
            $table->string('hubungan_hukum')->nullable();
            $table->string('dokumen_hub_hukum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
