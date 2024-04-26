<?php

namespace Database\Seeders;

use App\Models\Occupation;
use App\Models\Recruitment;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecruitmentSeeder extends Seeder
{
    use HasAdministrativeUnit;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $occupations = Occupation::all('id');
        $areas = $this->wards()->get('id');
        Recruitment::factory(100)
            ->create()
            ->each(function ($item) use ($occupations, $areas) {
                $item->occupations()->attach($occupations->random(rand(1, 5)));
                foreach ($areas->random(rand(1, 5)) as $area) {
                    $item->workingLocations()->attach($area, [
                        'detail_address' => fake()->streetAddress,
                        'map_url' => fake()->url,
                        'note' => fake()->paragraph(1),
                    ]);
                }

                DB::table('latest_recruitments')->insert([
                    'recruitment_id' => $item->id,
                    'company_id' => $item->company_id,
                    'number' => $item->number,
                ]);
            });
    }
}
