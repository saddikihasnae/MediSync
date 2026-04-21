<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['General Consultation', 'Dental Checkup', 'Blood Test', 'X-Ray', 'Physiotherapy']),
            'description' => fake()->sentence(),
            'duration_minutes' => fake()->randomElement([15, 30, 45, 60]),
            'price' => fake()->randomFloat(2, 20, 200),
        ];
    }
}
