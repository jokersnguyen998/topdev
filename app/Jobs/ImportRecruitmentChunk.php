<?php

namespace App\Jobs;

use App\Models\Recruitment;
use App\Services\Buyer\RecruitmentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportRecruitmentChunk implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uniqueFor = 3600;
    protected RecruitmentService $recruitmentService;
    
    /**
     * Create a new job instance.
     */
    public function __construct(public $chunk)
    {
        $this->recruitmentService = app()->make(RecruitmentService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(fn () => 
            $this->chunk->each(function (array $row) {
                $occupations = $row['recruitment_occupations'];
                unset($row['recruitment_occupations']);

                $workingLocations = $row['working_locations'];
                unset($row['working_locations']);

                $originRecruitment = Recruitment::revised()
                    ->whereIn('contact_branch_id', request()->user()->company->branches->pluck('id')->toArray())
                    ->where('number', '=', $row['number'])
                    ->first();

                if ($originRecruitment) {
                    $newRecruitment = $this->recruitmentService->storeFromOriginRecruitment($row, $originRecruitment);
                    
                    DB::table('latest_recruitments')
                        ->where([
                            'number' => $originRecruitment->number,
                            'company_id' => $originRecruitment->company_id,
                        ])
                        ->update([
                            'recruitment_id' => $newRecruitment->id,
                        ]);
                } else {
                    $newRecruitment = Recruitment::query()->create($row);

                    DB::table('latest_recruitments')->insert([
                        'recruitment_id' => $newRecruitment->id,
                        'company_id' => $newRecruitment->company_id,
                        'number' => $newRecruitment->number,
                    ]);
                }

                $newRecruitment->occupations()->attach($occupations);

                foreach ($workingLocations as $item) {
                    $newRecruitment->workingLocations()->attach($item['ward_id'], [
                        'detail_address' => $item['detail_address'],
                        'map_url' => $item['map_url'],
                        'note' => $item['note'],
                    ]);
                }
            })
        );
    }

    public function uniqueId(): string
    {
        return Str::uuid()->toString();
    }
}
