<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'role_id' => $adminRole->id,
        ]);

        User::factory()->create([
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'role_id' => $doctorRole->id,
        ]);

        User::factory()->create([
            'name' => 'Patient User',
            'email' => 'patient@example.com',
            'role_id' => $patientRole->id,
        ]);

        $this->call([
            AvailableTimeSeeder::class, 
            ReservationSeeder::class,
        ]);
    }
}
