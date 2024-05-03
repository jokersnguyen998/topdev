<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExperience>
 */
class WorkExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'worker_id' => Worker::inRandomOrder()->first('id')->id,
            'year' => rand(1999, 2024),
            'month' => rand(1, 12),
            'content' => $this->faker->sentence,
        ];
    }
}
