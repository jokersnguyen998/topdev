<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
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
        $branch = Branch::with('company')->inRandomOrder()->first();
        return [
            'branch_id' => $branch->id,
            'company_id' => $branch->company_id,
            'ward_id' => $this->wards()->inRandomOrder()->first('id')->id,
            'name' => $contactPerson,
            'email' => strtolower(str_replace(' ', '-', $contactPerson)) . substr(time(), -5) . '@mailinator.com',
            'password' => bcrypt('@Abcd12345'),
            'phone_number' => $branch->company->contact_phone_number,
            'gender' => rand(0, 1),
            'birthday' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'detail_address' => $this->faker->streetAddress,
        ];
    }
}
