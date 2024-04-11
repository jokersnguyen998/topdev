<?php

namespace Database\Factories;

use App\Enums\AdministrativeUnitType;
use App\Models\AdministrativeUnit;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::inRandomOrder()->first('id')->id,
            'ward_id' => AdministrativeUnit::whereIn('type', AdministrativeUnitType::wards())->inRandomOrder()->first('id')->id,
            'name' => $this->faker->company . ' ' . $this->faker->companySuffix,
            'phone_number' => $this->faker->numerify('0#########'),
            'detail_address' => null,
        ];
    }
}
