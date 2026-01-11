<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFinance extends Model
{
    protected $fillable = ['event_id', 'jenis', 'keterangan', 'nominal', 'tanggal'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}