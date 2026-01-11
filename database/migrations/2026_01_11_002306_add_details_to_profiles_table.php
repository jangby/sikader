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
    Schema::table('profiles', function (Blueprint $table) {
        $table->string('jenis_kelamin', 20)->nullable()->after('tanggal_lahir'); // Laki-laki / Perempuan
        $table->string('no_hp', 20)->nullable()->after('alamat');
    });
}

public function down(): void
{
    Schema::table('profiles', function (Blueprint $table) {
        $table->dropColumn(['jenis_kelamin', 'no_hp']);
    });
}
};
