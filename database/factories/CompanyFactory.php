<?php

namespace Database\Factories;

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
            'number' => $this->faker->numerify('####-####-####-####'),
            'name' => $this->faker->company . ' ' . $this->faker->companySuffix,
            'representative' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'zipcode' => $this->faker->numerify('######'),
            'province' => $this->faker->randomElement(['Can Tho']),
            'district' => $this->faker->randomElement(['Cai Rang', 'Ninh Kieu', 'Binh Thuy', 'Phong Dien']),
            'ward' => $this->faker->randomElement(['Cai Khe', 'Tan An', '']),
            'detail_address' => null,
            'phone_number' => $this->faker->numerify('0#########'),
            'homepage_url' => $this->faker->url,
            'contact_person' => $contactPerson,
            'contact_email' => str_replace(' ', '-', $contactPerson) . '@mailinator.com',
            'contact_phone_number' => $this->faker->numerify('0#########'),
        ];
    }
}
