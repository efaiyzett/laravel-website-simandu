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
        Schema::table('pemeriksaan_ibuhamil', function (Blueprint $table) {
            $table->string('pemeriksaan_darah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_ibuhamil', function (Blueprint $table) {
            $table->string('pemeriksaan_darah')->nullable(false)->change();
        });
    }
};
