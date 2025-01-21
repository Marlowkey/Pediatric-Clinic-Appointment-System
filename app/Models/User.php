<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Reservation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function reservations()
{
    return $this->hasMany(Reservation::class);
}

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (is_null($user->role_id)) {
                $patientRole = Role::where('name', 'patient')->first();
                $user->role_id = $patientRole->id ?? null;
            }
        });
    }
}
