<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Branch::each(fn ($branch) =>
            Employee::factory()
                ->recycle($branch)
                ->sequence(['company_id' => $branch->company_id])
                ->create()
        );
    }
}
