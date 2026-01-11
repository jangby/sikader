<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_acara'); // Misal: MAKESTA 2025
            $table->string('slug')->unique(); // untuk url: makesta-2025
            $table->string('jenis_kaderisasi'); // Makesta, Lakmud, Lakut
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->string('lokasi');
            $table->integer('kuota')->default(0); // 0 = unlimited
            $table->decimal('biaya', 10, 2)->default(0); // 0 = gratis
            $table->boolean('is_active')->default(true); // Status pendaftaran buka/tutup
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};