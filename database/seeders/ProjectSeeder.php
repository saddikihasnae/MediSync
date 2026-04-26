<?php

namespace database\seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\MedicalReport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Services
        $services = [
            ['name' => 'General Consultation', 'price' => 50, 'duration_minutes' => 30],
            ['name' => 'Dental Checkup', 'price' => 80, 'duration_minutes' => 45],
            ['name' => 'Cardiology', 'price' => 150, 'duration_minutes' => 60],
            ['name' => 'Pediatrics', 'price' => 60, 'duration_minutes' => 30],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Doctors
        User::create([
            'name' => 'Dr. Ahmed Ali',
            'email' => 'doctor@medisync.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        // Create 15 Patients with age
        $patients = User::factory(15)->create([
            'role' => 'patient',
            'age' => rand(18, 75),
        ]);

        // Create some Medical Reports
        foreach ($patients->take(5) as $patient) {
            MedicalReport::create([
                'patient_id' => $patient->id,
                'type' => collect(['Blood Analysis', 'X-Ray', 'Prescription'])->random(),
                'content' => 'Initial checkup results for ' . $patient->name,
            ]);
        }

        // Create 20 Appointments
        $doctor = User::where('role', 'doctor')->first();
        $allServices = Service::all();

        for ($i = 0; $i < 20; $i++) {
            Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctor->id,
                'service_id' => $allServices->random()->id,
                'appointment_date' => now()->addDays(rand(-1, 30))->addHours(rand(1, 8)),
                'status' => collect(['pending', 'confirmed', 'completed', 'cancelled'])->random(),
                'notes' => 'Test appointment ' . ($i + 1),
            ]);
        }
    }
}
