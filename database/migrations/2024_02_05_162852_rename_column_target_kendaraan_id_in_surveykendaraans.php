<?php

use App\Models\Target2;
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
            $table->dropColumn('target_kendaraan_id');
            $table->foreignIdFor(Target2::class)->nullable();
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
