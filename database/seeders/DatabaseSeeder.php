<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1 Admin (Doctor)
        User::factory()->create([
            'name' => 'Dr. Ahmed Ali',
            'email' => 'doctor@medisync.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        // 10 Patients
        User::factory(10)->create(['role' => 'patient']);

        // 4 Services
        Service::factory(6)->create();

        // 20 Appointments
        Appointment::factory(20)->create();
    }
}
