<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MeetingRoom;
use Illuminate\Database\Seeder;

class MeetingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Company::each(fn ($company) =>
            MeetingRoom::factory()->recycle($company)->create()
        );
    }
}
