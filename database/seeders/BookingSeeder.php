<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Employee::each(fn ($employee) =>
            Booking::factory()
                ->recycle($employee)
                ->sequence([
                    'branch_id' => $employee->branch_id,
                    'company_id' => $employee->company_id,
                ])
                ->create()
        );
    }
}
