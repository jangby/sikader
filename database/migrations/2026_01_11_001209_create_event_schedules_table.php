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
    Schema::create('event_schedules', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->onDelete('cascade');
        $table->string('nama_sesi'); // Misal: Materi 1 - Aswaja
        $table->dateTime('waktu_mulai');
        $table->dateTime('waktu_selesai');
        $table->string('penanggung_jawab')->nullable(); // Nama Pemateri / Moderator
        $table->string('file_materi')->nullable(); // Link download materi (PPT/PDF)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_schedules');
    }
};
