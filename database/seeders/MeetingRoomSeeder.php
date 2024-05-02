<?php

namespace Database\Seeders;

use App\Models\MeetingRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetingRoom::factory(20)->create();
    }
}
