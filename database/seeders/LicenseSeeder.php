<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Worker::each(fn ($worker) =>
            License::factory(rand(1, 3))->recycle($worker)->create()
        );
    }
}
