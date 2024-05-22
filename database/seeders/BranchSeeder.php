<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Company::each(fn ($company) =>
            Branch::factory()->recycle($company)->create()
        );
    }
}
