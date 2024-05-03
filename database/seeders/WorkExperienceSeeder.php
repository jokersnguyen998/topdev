<?php

namespace Database\Seeders;

use App\Models\WorkExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkExperience::factory(50)->create();
    }
}
