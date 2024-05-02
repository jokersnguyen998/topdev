<?php

namespace App\Http\Resources\Buyer;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingRoomResource extends JsonResource
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
                'name' => $this->resource->name,
                'is_online' => $this->resource->is_online,
                'detail_address' => $this->when($this->resource->is_online == false, $this->resource->detail_address),
                'url' => $this->when($this->resource->is_online == true, $this->resource->url),
            ],
            'relationships' => [
                'ward' => new AdministrativeUnitResource(
                    $this->when(
                        $this->resource->is_online == false,
                        $this->whenLoaded('ward')
                    )
                ),
                'company' => new CompanyResource($this->whenLoaded('company')),
            ],
        ];
    }
}
