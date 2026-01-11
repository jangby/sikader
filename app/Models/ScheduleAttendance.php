<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleAttendance extends Model
{
    protected $fillable = ['event_schedule_id', 'registration_id', 'scanned_at'];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function schedule()
    {
        return $this->belongsTo(EventSchedule::class, 'event_schedule_id');
    }
}