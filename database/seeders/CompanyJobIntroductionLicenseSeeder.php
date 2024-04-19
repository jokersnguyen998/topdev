<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyJobIntroductionLicense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyJobIntroductionLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();
        CompanyJobIntroductionLicense::factory(rand(1, $companies->count()))->recycle($companies)->create();
    }
}
