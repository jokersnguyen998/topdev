<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
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
            'work_summary' => $this->faker->paragraph(rand(3, 5)),
            'specialty' => $this->faker->paragraph(rand(3, 5)),
            'tools' => $this->faker->paragraph(rand(3, 5)),
            'self_promotion' => $this->faker->paragraph(rand(3, 5)),
        ];
    }
}
