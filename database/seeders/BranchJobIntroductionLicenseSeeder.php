<?php

namespace Database\Seeders;

use App\Models\AdministrativeUnit;
use App\Models\Branch;
use App\Models\BranchJobIntroductionLicense;
use App\Models\Occupation;
use Illuminate\Database\Seeder;

class BranchJobIntroductionLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $occupations = Occupation::all();
        $areas = AdministrativeUnit::provinces()->get();

        Branch::each(fn ($branch) =>
            BranchJobIntroductionLicense::factory()
                ->recycle($branch)
                ->afterCreating(function ($item) use ($occupations, $areas) {
                    $item->serviceAreas()->attach($areas->random());
                    $item->serviceOccupations()->attach($occupations->random());
                })
                ->create()
        );
    }
}
