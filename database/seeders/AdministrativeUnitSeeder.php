<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdministrativeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $sqlString = "INSERT INTO administrative_units (`id`, `name`, `type`, `parent_id`) VALUES ";
        $filePath = public_path('seeders/administrative_units.csv');
        if (File::exists($filePath)) {
            $areas = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $areas = array_chunk($areas, 1000);
            foreach ($areas as $row) {
                DB::insert($sqlString . implode(',', $row));
            }
        }
    }
}
