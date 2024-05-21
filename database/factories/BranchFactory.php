<?php

namespace Database\Factories;

use App\Models\Company;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    use HasAdministrativeUnit;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'ward_id' => $this->wards()->inRandomOrder()->first('id')->id,
            'name' => $this->faker->company . ' ' . $this->faker->companySuffix,
            'phone_number' => $this->faker->numerify('0#########'),
            'detail_address' => null,
        ];
    }
}
