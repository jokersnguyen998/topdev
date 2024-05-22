<?php

namespace Database\Seeders;

use App\Models\AcademicLevel;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class AcademicLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Worker::each(fn ($worker) =>
            AcademicLevel::factory(rand(1, 3))->recycle($worker)->create()
        );
    }
}
