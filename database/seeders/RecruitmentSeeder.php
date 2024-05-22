<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Occupation;
use App\Models\Recruitment;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecruitmentSeeder extends Seeder
{
    use HasAdministrativeUnit;

    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $occupations = Occupation::all('id');
        $areas = $this->wards()->get('id');

        Employee::each(fn ($employee) =>
            Recruitment::factory()
                ->recycle($employee)
                ->sequence([
                    'contact_branch_id' => $employee->branch_id,
                    'company_id' => $employee->company_id,
                ])
                ->hasAttached(
                    $occupations->random(rand(1, 5)),
                    [],
                    'occupations'
                )
                ->hasAttached(
                    $areas->random(rand(1, 5)),
                    [
                        'detail_address' => fake()->streetAddress,
                        'map_url' => fake()->url,
                        'note' => fake()->paragraph(1),
                    ],
                    'workingLocations'
                )
                ->afterCreating(fn ($recruitment) => \DB::table('latest_recruitments')
                    ->insert([
                        'recruitment_id' => $recruitment->id,
                        'company_id' => $recruitment->company_id,
                        'number' => $recruitment->number,
                    ])
                )
                ->create()
        );
    }
}
