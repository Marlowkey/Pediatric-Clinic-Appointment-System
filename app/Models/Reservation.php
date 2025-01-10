<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_date',
        'available_time_id',
        'start_time',
        'end_time',
        'patient_name',
        'guardian_name',
        'phone_number',
        'message',
        'status',
    ];
    public function availableTime()
    {
        return $this->belongsTo(AvailableTime::class, 'available_time_id');
    }
}
