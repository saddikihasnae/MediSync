<?php

namespace Database\Factories;

use App\Models\MedicalReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalReport>
 */
class MedicalReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Blood Test', 'X-Ray Scan', 'MRI Report', 'General Check'];
        
        return [
            'report_id' => 'REP-' . $this->faker->unique()->numberBetween(1000, 9999),
            'patient_id' => User::where('role', 'patient')->inRandomOrder()->first()?->id ?? User::factory(),
            'type' => $this->faker->randomElement($types),
            'report_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'result_summary' => $this->faker->paragraph(3),
        ];
    }
}
