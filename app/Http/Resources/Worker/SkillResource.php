<?php

namespace App\Http\Resources\Worker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'work_summary' => $this->resource->work_summary,
            'specialty' => $this->resource->specialty,
            'tools' => $this->resource->tools,
            'self_promotion' => $this->resource->self_promotion,
            'job_careers' => JobCareerResource::collection($this->whenLoaded('jobCareers')),
        ];
    }
}
