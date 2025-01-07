<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        Reservation::factory()->count(50)->create(); // Adjust count as needed
    }
}
