<?php

namespace Database\Seeders;

use App\Models\AdministrativeUnit;
use App\Models\Company;
use App\Models\CompanyJobIntroductionLicense;
use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyJobIntroductionLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $occupations = Occupation::all();
        $areas = AdministrativeUnit::provinces()->get();
        $companies = Company::all();
        CompanyJobIntroductionLicense::factory(rand(1, $companies->count()))
            ->recycle($companies)
            ->create()
            ->each(function($item) use ($occupations, $areas) {
                $item->serviceAreas()->attach($areas->random()->take(rand(1, 5))->pluck('id'));
                $item->serviceOccupations()->attach($occupations->random()->take(rand(1, 5))->pluck('id'));
            });
    }
}
