<?php

namespace App\Http\Resources\Worker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkExperienceResource extends JsonResource
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
            'year' => $this->resource->year,
            'month' => $this->resource->month,
            'content' => $this->resource->content,
        ];
    }
}
