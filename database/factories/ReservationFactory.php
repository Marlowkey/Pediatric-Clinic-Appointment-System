<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\AvailableTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'schedule_date' => $this->faker->dateTimeBetween('2025-01-01', '2025-01-31')->format('Y-m-d'),
            'available_time_id' => AvailableTime::inRandomOrder()->first()->id,
            'patient_name' => $this->faker->name(),
            'guardian_name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'message' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
