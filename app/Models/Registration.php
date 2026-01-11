<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'bukti_pembayaran',
        'certificate_link',
        'ukuran_baju',
        'data_dokumen',
    ];

    protected $casts = [
    'data_dokumen' => 'array', // <-- PENTING
];

    // Pendaftaran milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pendaftaran untuk satu Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}