<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Reservation;
use App\Models\AvailableTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;
    public function definition()
    {
        $availableTime = AvailableTime::inRandomOrder()->first();
        $user = User::whereHas('role', function ($query) {
            $query->where('name', 'patient');
        })
            ->inRandomOrder()
            ->first();

        return [
            'schedule_date' => $this->faker->dateTimeBetween('now', '2025-02-10')->format('Y-m-d'),
            'start_time' => $availableTime->start_time,
            'end_time' => $availableTime->end_time,
            'patient_name' => $this->faker->name(),
            'guardian_name' => $user ? $user->name : $this->faker->name(), // Set guardian_name to user name
            'phone_number' => $this->faker->unique()->regexify('^\\+639[0-9]{9}$'),
            'message' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'completed']),
            'user_id' => $user?->id,
        ];
    }
}
