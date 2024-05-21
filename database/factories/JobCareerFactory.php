<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobCareer>
 */
class JobCareerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'skill_id' => Skill::factory(),
            'company_name' => $this->faker->company,
            'department_name' => $this->faker->name,
            'year' => rand(1999, 2024),
            'month' => rand(1, 12),
            'is_retired' => rand(0, 1),
            'environment' => $this->faker->paragraph,
            'role' => $this->faker->sentence,
            'technique' => $this->faker->paragraph,
        ];
    }
}
