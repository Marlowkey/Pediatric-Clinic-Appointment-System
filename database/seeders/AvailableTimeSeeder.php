<?php

namespace Database\Seeders;

use App\Models\AvailableTime;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AvailableTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $times = [
            '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM',
            '11:30 AM', '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM',
            '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM',
        ];

        foreach ($times as $time) {
            AvailableTime::create(['time_slot' => $time]);
        }
    }
}
