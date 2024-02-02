<?php

use App\Models\target_kendaraan;
use App\Models\TargetKendaraan;
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
            $table->foreignIdFor(TargetKendaraan::class)->nullable();
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
