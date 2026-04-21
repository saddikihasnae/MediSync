<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => User::where('role', 'patient')->count() > 0 ? User::where('role', 'patient')->inRandomOrder()->first()->id : User::factory(['role' => 'patient']),
            'doctor_id' => User::where('role', 'doctor')->count() > 0 ? User::where('role', 'doctor')->inRandomOrder()->first()->id : User::factory(['role' => 'doctor']),
            'service_id' => Service::inRandomOrder()->first()?->id ?? Service::factory(),
            'appointment_time' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
