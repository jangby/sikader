<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (untuk login)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Biodata sesuai permintaan
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            
            // Alamat lengkap
            $table->text('alamat'); // Nama jalan / blok
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('desa'); // ds
            $table->string('kecamatan'); // kec
            $table->string('kabupaten'); // kab
            
            $table->string('asal_delegasi'); // Pimpinan Ranting / Komisariat mana
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};