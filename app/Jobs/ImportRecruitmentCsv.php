<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ImportRecruitmentCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $data)
    {
        if (!$data instanceof Collection) {
            $this->data = collect($data);
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->data->chunk(5000)
            ->each(fn ($chunk) => ImportRecruitmentChunk::dispatch($chunk));
    }
}
