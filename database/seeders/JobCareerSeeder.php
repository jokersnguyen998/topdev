<?php

namespace Database\Seeders;

use App\Models\JobCareer;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class JobCareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Skill::each(fn ($skill) =>
            JobCareer::factory(rand(1, 3))->recycle($skill)->create()
        );
    }
}
