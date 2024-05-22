<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $sqlString = "INSERT INTO occupations (`id`, `name`, `parent_id`) VALUES ";
        $filePath = public_path('seeders/occupations.csv');
        if (File::exists($filePath)) {
            $occupations = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $occupations = array_chunk($occupations, 1000);
            foreach ($occupations as $row) {
                DB::insert($sqlString . implode(',', $row));
            }
        }
    }
}
