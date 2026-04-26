<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
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
            'name' => fake()->randomElement(['General Consultation', 'Dental Checkup', 'Cardiology', 'Pediatrics', 'Radiology', 'Surgery']),
            'price' => fake()->numberBetween(50, 500),
            'duration_minutes' => fake()->randomElement([30, 45, 60]),
            'description' => fake()->sentence(),
        ];
    }
}
