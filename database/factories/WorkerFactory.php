<?php

namespace Database\Factories;

use App\Models\AdministrativeUnit;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    use HasAdministrativeUnit;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contactPerson = $this->faker->firstName . ' ' . $this->faker->lastName;
        return [
            'ward_id' => $this->wards()->inRandomOrder()->first('id')->id,
            'contact_ward_id' => AdministrativeUnit::wards()->inRandomOrder()->first('id')->id,
            'name' => $contactPerson,
            'email' => strtolower(str_replace(' ', '-', $contactPerson)) . substr(time(), -5) . '@mailinator.com',
            'password' => bcrypt('@Abcd12345'),
            'phone_number' => $this->faker->numerify('0#########'),
            'gender' => rand(0, 1),
            'birthday' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'detail_address' => $this->faker->streetAddress,
            'avatar_url' => $this->faker->imageUrl,
            'contact_detail_address' => $this->faker->streetAddress,
            'contact_phone_number' => $this->faker->numerify('0#########'),
            'terms_of_use_agreement_at' => now(),
            'privacy_policy_agreement_at' => now(),
            'withdrawn_at' => null,
            'last_login_at' => null,
        ];
    }
}
