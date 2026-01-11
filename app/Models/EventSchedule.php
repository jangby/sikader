<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    protected $fillable = [
        'event_id',
        'nama_sesi',
        'waktu_mulai',
        'waktu_selesai',
        'penanggung_jawab', // Pemateri atau Moderator
        'file_materi',      // Path file upload
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function attendances()
{
    return $this->hasMany(ScheduleAttendance::class);
}
}