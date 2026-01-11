<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'nama_acara',
        'slug',
        'banner',
        'jenis_kaderisasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'kuota',
        'biaya',
        'is_active',
        'harga_tiket',
        'config_dokumen',
        'info_pembayaran',
    ];

    // Agar format tanggal otomatis rapi saat dipanggil
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'config_dokumen' => 'array',
        'info_pembayaran' => 'array',
        'is_active' => 'boolean',
    ];

    // Event punya banyak pendaftar
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function schedules()
{
    return $this->hasMany(EventSchedule::class);
}

public function finances() { return $this->hasMany(EventFinance::class); }
}