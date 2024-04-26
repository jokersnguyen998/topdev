<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkingLocationResource extends JsonResource
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
            'detail_address' => $this->resource->detail_address,
            'map_url' => $this->resource->map_url,
            'note' => $this->resource->note,
            'ward' => [
                'id' => $this->resource->pivot->ward_id,
                'type' => $this->resource->type,
                'name' => $this->resource->name,
                'district' => new AdministrativeUnitResource($this->whenLoaded('district'))
            ],
        ];
    }
}
