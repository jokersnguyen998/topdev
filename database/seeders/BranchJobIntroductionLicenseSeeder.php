<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchJobIntroductionLicense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchJobIntroductionLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        BranchJobIntroductionLicense::factory(rand(1, $branches->count()))->recycle($branches)->create();
    }
}
