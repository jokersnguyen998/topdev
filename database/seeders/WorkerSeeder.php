<?php

namespace Database\Seeders;

use App\Models\AcademicLevel;
use App\Models\Company;
use App\Models\JobCareer;
use App\Models\License;
use App\Models\ReferralConnection;
use App\Models\Skill;
use App\Models\Worker;
use App\Models\WorkExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::query()
            ->whereHas('companyJobIntroductionLicense', fn ($query) => $query
                ->where('expired_date', '>', today())
            )
            ->inRandomOrder()
            ->take(5)
            ->get();

        collect(range(1, 20))
            ->each(fn () =>
                Worker::factory()
                    ->has(
                        Skill::factory()
                            ->has(
                                JobCareer::factory(rand(1, 3)),
                                'jobCareers',
                            ),
                        'skill',
                    )
                    ->has(
                        AcademicLevel::factory(rand(1, 3)),
                        'academicLevels',
                    )
                    ->has(
                        WorkExperience::factory(rand(1, 3)),
                        'workExperiences',
                    )
                    ->has(
                        License::factory(rand(1, 3)),
                        'licenses',
                    )
                    ->has(
                        ReferralConnection::factory(rand(1, $companies->count()))
                            ->sequence(fn($sequence) => [
                                'is_first' => $sequence->index === 0,
                                'company_id' => $companies[$sequence->index]->id,
                            ]),
                        'referralConnections',
                    )
                    ->create()
        );
    }
}
