<?php

namespace App\Http\Resources\Worker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobCareerResource extends JsonResource
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
            'company_name' => $this->resource->company_name,
            'department_name' => $this->resource->department_name,
            'year' => $this->resource->year,
            'month' => $this->resource->month,
            'is_retired' => $this->resource->is_retired,
            'environment' => $this->resource->environment,
            'role' => $this->resource->role,
            'technique' => $this->resource->technique,
        ];
    }
}
