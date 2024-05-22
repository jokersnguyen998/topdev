<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        $this->call([
            AdministrativeUnitSeeder::class,
            OccupationSeeder::class,
        ]);

        if (config('app.env') === 'local') {
            $this->call([
                CompanySeeder::class,
                CompanyJobIntroductionLicenseSeeder::class,
                BranchSeeder::class,
                BranchJobIntroductionLicenseSeeder::class,
                EmployeeSeeder::class,
                MeetingRoomSeeder::class,
                BookingSeeder::class,
                RecruitmentSeeder::class,
                WorkerSeeder::class,
                SkillSeeder::class,
                JobCareerSeeder::class,
                AcademicLevelSeeder::class,
                WorkExperienceSeeder::class,
                LicenseSeeder::class,
                ReferralConnectionSeeder::class,
            ]);
        }
    }
}
