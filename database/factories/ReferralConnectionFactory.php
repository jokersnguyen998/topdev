<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReferralConnection>
 */
class ReferralConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRequestedToEnterResume = rand(0, 1);
        return [
            'company_id' => Company::inRandomOrder()->first('id')->id,
            'worker_id' => Worker::inRandomOrder()->first('id')->id,
            'published_resume_at' => rand(0, 1) ? now() : null,
            'published_experience_at' => rand(0, 1) ? now() : null,
            'requested_to_enter_resume_at' => $isRequestedToEnterResume ? now() : null,
            'completed_resume_at' => $isRequestedToEnterResume && rand(0, 1) ? now() : null,
            'is_first' => rand(0, 1),
            'memo' => $this->faker->paragraph,
        ];
    }
}
