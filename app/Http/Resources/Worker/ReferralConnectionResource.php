<?php

namespace App\Http\Resources\Worker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferralConnectionResource extends JsonResource
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
            'attributes' => [
                'published_resume_at' => $this->resource->published_resume_at,
                'published_experience_at' => $this->resource->published_experience_at,
                'requested_to_enter_resume_at' => $this->resource->requested_to_enter_resume_at,
                'completed_resume_at' => $this->resource->completed_resume_at,
                'is_first' => $this->resource->is_first,
                'memo' => $this->resource->memo,
                'created_at' => $this->resource->created_at,
            ],
            'relationships' => [
                'company' => new CompanyResource($this->whenLoaded('company')),
            ],
        ];
    }
}
