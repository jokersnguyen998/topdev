<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Worker::each(fn ($worker) =>
            Skill::factory()->recycle($worker)->create()
        );
    }
}
