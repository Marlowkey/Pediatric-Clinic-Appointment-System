<?php

namespace App\Models;

use App\Models\AvailableTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnavailableTimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'available_time_id'];

    /**
     * Relationship with AvailableTime.
     */
    public function availableTime()
    {
        return $this->belongsTo(AvailableTime::class);
    }
}
