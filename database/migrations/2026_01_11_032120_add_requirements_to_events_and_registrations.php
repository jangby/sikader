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
    // 1. Tambah Konfigurasi Dokumen di Tabel Events
    Schema::table('events', function (Blueprint $table) {
        // Menyimpan aturan dokumen dalam format JSON
        // Contoh: [{"nama": "Sertifikat Makesta", "wajib": true}, {"nama": "KTP", "wajib": false}]
        $table->json('config_dokumen')->nullable()->after('biaya');
    });

    // 2. Tambah Data Peserta di Tabel Registrations
    Schema::table('registrations', function (Blueprint $table) {
        $table->string('ukuran_baju', 5)->nullable()->after('status'); // S, M, L, XL, XXL
        $table->json('data_dokumen')->nullable()->after('ukuran_baju'); // Menyimpan path file yang diupload
    });
}

public function down(): void
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('config_dokumen');
    });
    Schema::table('registrations', function (Blueprint $table) {
        $table->dropColumn(['ukuran_baju', 'data_dokumen']);
    });
}
};
