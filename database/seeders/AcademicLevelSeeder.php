<?php

namespace Database\Seeders;

use App\Models\AcademicLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicLevel::factory(50)->create();
    }
}
