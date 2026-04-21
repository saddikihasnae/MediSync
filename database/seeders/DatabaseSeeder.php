<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 doctors
        \App\Models\User::factory(5)->create(['role' => 'doctor']);

        // Create 10 patients
        \App\Models\User::factory(10)->create(['role' => 'patient']);

        // Create 5 medical services
        \App\Models\Service::factory(5)->create();

        // Create 20 appointments
        \App\Models\Appointment::factory(20)->create();
    }
}
