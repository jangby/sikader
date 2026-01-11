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
    // 1. Tabel Transaksi Keuangan (Manual)
    Schema::create('event_finances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->onDelete('cascade');
        $table->enum('jenis', ['pemasukan', 'pengeluaran']); // Tipe Transaksi
        $table->string('keterangan'); // Contoh: Sponsor PT X, Beli Kertas
        $table->decimal('nominal', 15, 0); // Uang
        $table->date('tanggal');
        $table->timestamps();
    });

    // 2. Tambah kolom Harga di tabel Event (Jika belum ada)
    if (!Schema::hasColumn('events', 'harga_tiket')) {
        Schema::table('events', function (Blueprint $table) {
            $table->decimal('harga_tiket', 15, 0)->default(0)->after('lokasi');
        });
    }
}

public function down(): void
{
    Schema::dropIfExists('event_finances');
    if (Schema::hasColumn('events', 'harga_tiket')) {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('harga_tiket');
        });
    }
}
};
