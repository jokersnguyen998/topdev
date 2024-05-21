<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\BranchJobIntroductionLicense;
use App\Models\Company;
use App\Models\CompanyJobIntroductionLicense;
use App\Models\Employee;
use App\Models\MeetingRoom;
use App\Models\Occupation;
use App\Models\Recruitment;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    use HasAdministrativeUnit;
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $occupations = Occupation::all('id');
        $areas = $this->wards()->get('id');

        collect(range(1, 3))
            ->each(fn() => 
                Company::factory()
                    ->has(CompanyJobIntroductionLicense::factory(), 'companyJobIntroductionLicense')
                    ->has(
                        Branch::factory()
                            ->has(BranchJobIntroductionLicense::factory(), 'branchJobIntroductionLicense')
                            ->has(
                                Employee::factory()
                                    ->has(
                                        Recruitment::factory(rand(1, 10))
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
                                            ->afterCreating(fn($recruitment) => \DB::table('latest_recruitments')
                                                ->insert([
                                                    'recruitment_id' => $recruitment->id,
                                                    'company_id' => $recruitment->company_id,
                                                    'number' => $recruitment->number,
                                                ])
                                            ),
                                        'recruitments'
                                    )
                                    ->has(Booking::factory(), 'bookings'),
                                'employees'
                            ),
                        'branches'
                    )
                    ->has(MeetingRoom::factory(), 'meetingRooms')
                    ->create()
            );
    }
}
