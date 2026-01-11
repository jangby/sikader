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
    Schema::create('schedule_attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_schedule_id')->constrained()->onDelete('cascade');
        $table->foreignId('registration_id')->constrained()->onDelete('cascade');
        $table->timestamp('scanned_at'); // Waktu scan
        $table->timestamps();

        // Mencegah absen ganda di satu sesi
        $table->unique(['event_schedule_id', 'registration_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('schedule_attendances');
}
};
