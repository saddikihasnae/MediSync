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

        // 2 Specific Patients for Testing
        User::factory()->create([
            'name' => 'Sarah Johnson',
            'email' => 'patient1@medisync.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        User::factory()->create([
            'name' => 'Michael Smith',
            'email' => 'patient2@medisync.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        // 8 Random Patients
        User::factory(8)->create(['role' => 'patient']);

        // 6 Services
        Service::factory(6)->create();

        // 20 Appointments
        Appointment::factory(20)->create();

        // 20 Medical Reports
        \App\Models\MedicalReport::factory(20)->create();
    }
}
