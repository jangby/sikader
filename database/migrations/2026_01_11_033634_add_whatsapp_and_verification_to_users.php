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
    // 1. Update tabel Users
    Schema::table('users', function (Blueprint $table) {
        $table->string('no_hp')->unique()->nullable()->after('email');
        $table->timestamp('wa_verified_at')->nullable()->after('email_verified_at');
    });

    // 2. Buat tabel Verification Codes (Untuk simpan OTP)
    Schema::create('verification_codes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('code', 6);
        $table->enum('type', ['email', 'whatsapp']); // Jenis kode
        $table->timestamp('expires_at');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('verification_codes');
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['no_hp', 'wa_verified_at']);
    });
}
};
