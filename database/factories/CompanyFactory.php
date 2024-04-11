<?php

namespace Database\Factories;

use App\Enums\AdministrativeUnitType;
use App\Models\AdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contactPerson = $this->faker->firstName . ' ' . $this->faker->lastName;
        return [
            'ward_id' => AdministrativeUnit::whereIn('type', AdministrativeUnitType::wards())->inRandomOrder()->first('id')->id,
            'number' => $this->faker->numerify('####-####-####-####'),
            'name' => $this->faker->company . ' ' . $this->faker->companySuffix,
            'representative' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'detail_address' => null,
            'phone_number' => $this->faker->numerify('0#########'),
            'homepage_url' => $this->faker->url,
            'contact_person' => $contactPerson,
            'contact_email' => strtolower(str_replace(' ', '-', $contactPerson)) . substr(time(), -5) . '@mailinator.com',
            'contact_phone_number' => $this->faker->numerify('0#########'),
        ];
    }
}
