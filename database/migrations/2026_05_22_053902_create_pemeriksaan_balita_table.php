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
        Schema::create('pemeriksaan_balita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('balita')->onDelete('cascade');
            $table->decimal('berat');
            $table->decimal('tinggi');
            $table->foreignId('imunisasi_id')->nullable()->constrained('imunisasi')->nullOnDelete();
            $table->date('tanggal_pemeriksaan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_balita');
    }
};
