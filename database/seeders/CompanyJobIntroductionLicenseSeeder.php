<?php

namespace Database\Seeders;

use App\Models\AdministrativeUnit;
use App\Models\Company;
use App\Models\CompanyJobIntroductionLicense;
use App\Models\Occupation;
use Illuminate\Database\Seeder;

class CompanyJobIntroductionLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $occupations = Occupation::all();
        $areas = AdministrativeUnit::provinces()->get();

        Company::each(fn ($company) =>
            CompanyJobIntroductionLicense::factory()
                ->recycle($company)
                ->afterCreating(function ($item) use ($occupations, $areas) {
                    $item->serviceAreas()->attach($areas->random());
                    $item->serviceOccupations()->attach($occupations->random());
                })
                ->create()
        );
    }
}
