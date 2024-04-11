<?php

namespace Database\Factories;

use App\Models\AdministrativeUnit;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
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
            'ward_id' => AdministrativeUnit::wards()->inRandomOrder()->first('id')->id,
            'name' => $contactPerson,
            'email' => strtolower(str_replace(' ', '-', $contactPerson)) . substr(time(), -5) . '@mailinator.com',
            'password' => Hash::make('@Abcd12345'),
            'phone_number' => $branch->company->contact_phone_number,
            'detail_address' => null,
        ];
    }
}
