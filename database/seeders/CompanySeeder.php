<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    use HasAdministrativeUnit;

    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Company::factory()->create();
    }
}
