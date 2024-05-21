<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BranchJobIntroductionLicense>
 */
class BranchJobIntroductionLicenseFactory extends Factory
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
            'branch_id' => Branch::factory(),
            'ward_id' => $this->wards()->inRandomOrder()->first('id')->id,
            'detail_address' => $this->faker->streetAddress,
            'license_url' => $this->faker->url,
            'detail_url' => $this->faker->url,
        ];
    }
}
