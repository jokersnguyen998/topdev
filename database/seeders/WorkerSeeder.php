<?php

namespace Database\Seeders;

use App\Models\JobCareer;
use App\Models\Skill;
use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(range(0, 19))
            ->each(function () {
                Worker::factory()
                    ->has(
                        Skill::factory()
                            ->has(
                                JobCareer::factory(rand(1, 3)),
                                'jobCareers'
                            ),
                            'skill'
                    )
                    ->create();
            });
    }
}
