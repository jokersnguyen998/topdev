<?php

namespace Database\Factories;

use App\Models\Company;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeetingRoom>
 */
class MeetingRoomFactory extends Factory
{
    use HasAdministrativeUnit;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isOnline = rand(0, 1);
        return [
            'company_id' => Company::factory(),
            'ward_id' => $isOnline ? null : $this->wards()->inRandomOrder()->first('id')->id,
            'name' => $this->faker->streetName,
            'is_online' => $isOnline,
            'url' => $isOnline ? $this->faker->url : null,
            'detail_address' => $isOnline ? null : $this->faker->streetAddress,
        ];
    }
}
