<?php

namespace Database\Seeders;

use App\Models\AdministrativeUnit;
use App\Models\Branch;
use App\Models\BranchJobIntroductionLicense;
use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchJobIntroductionLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $occupations = Occupation::all();
        $areas = AdministrativeUnit::provinces()->get();
        $branches = Branch::all();
        BranchJobIntroductionLicense::factory(rand(1, $branches->count()))
            ->recycle($branches)
            ->create()
            ->each(function($item) use ($occupations, $areas) {
                $item->serviceAreas()->attach($areas->random()->take(rand(1, 5))->pluck('id'));
                $item->serviceOccupations()->attach($occupations->random()->take(rand(1, 5))->pluck('id'));
            });
    }
}
