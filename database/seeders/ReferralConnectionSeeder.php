<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\ReferralConnection;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class ReferralConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $companies = Company::query()
            ->whereHas('companyJobIntroductionLicense', fn ($query) =>
                $query->where('expired_date', '>', today())
            )
            ->inRandomOrder()
            ->take(5)
            ->get();

        Worker::each(fn ($worker) =>
            ReferralConnection::factory($companies->count())
                ->recycle($worker)
                ->sequence(fn ($sequence) => [
                    'is_first' => $sequence->index === 0,
                    'company_id' => $companies[$sequence->index]->id,
                ])
                ->create()
        );
    }
}
