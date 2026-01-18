<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'no_hp',
        'password',
        'role',
        'wa_verified_at',   // <--- WAJIB DITAMBAHKAN
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- TAMBAHKAN KODE INI DI BAWAH ---

    // Satu User punya Satu Profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Satu User bisa punya Banyak Pendaftaran (ikut Makesta, lalu ikut Lakmud, dst)
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}