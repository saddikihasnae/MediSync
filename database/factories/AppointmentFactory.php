<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
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
        // Mix of past and current/future dates
        $date = fake()->randomElement([
            now()->subWeeks(2)->addDays(rand(1, 14)), // Past
            now()->startOfWeek(Carbon::MONDAY)->addDays(rand(0, 5))->setHour(rand(8, 16)), // This week Mon-Sat
        ]);

        return [
            'patient_id' => User::where('role', 'patient')->inRandomOrder()->first()?->id ?? User::factory(),
            'doctor_id' => User::where('role', 'doctor')->first()?->id ?? User::factory(['role' => 'doctor']),
            'service_id' => Service::inRandomOrder()->first()?->id ?? Service::factory(),
            'appointment_date' => $date,
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'notes' => fake()->paragraph(),
        ];
    }
}
