<?php

namespace Database\Seeders;

use App\Models\Worker;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;

class WorkExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Worker::each(fn ($worker) =>
            WorkExperience::factory(rand(1, 3))->recycle($worker)->create()
        );
    }
}
