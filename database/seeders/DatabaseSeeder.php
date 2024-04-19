<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdministrativeUnitSeeder::class,
            CompanySeeder::class,
            CompanyJobIntroductionLicenseSeeder::class,
            BranchSeeder::class,
            BranchJobIntroductionLicenseSeeder::class,
            EmployeeSeeder::class,
            WorkerSeeder::class,
        ]);
    }
}
