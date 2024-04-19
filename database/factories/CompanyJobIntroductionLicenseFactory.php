<?php

namespace Database\Factories;

use App\Models\Company;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyJobIntroductionLicense>
 */
class CompanyJobIntroductionLicenseFactory extends Factory
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
            'company_id' => $this->faker->unique()->randomElement(Company::pluck('id')->toArray()),
            'ward_id' => $this->wards()->inRandomOrder()->first('id')->id,
            'license_number_1' => $this->faker->numerify('####'),
            'license_number_2' => $this->faker->bothify('?'),
            'license_number_3' => $this->faker->numerify('####'),
            'license_url' => $this->faker->url,
            'issue_date' => $this->faker->dateTimeBetween('-5 years')->format('Y-m-d'),
            'expired_date' => $this->faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
            'is_excellent_referral' => $this->faker->boolean(30),
            'detail_url' => $this->faker->url,
            'detail_address' => $this->faker->streetAddress,
        ];
    }
}
