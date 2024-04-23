<?php

namespace App\Http\Resources\Buyer;

use App\Http\Resources\Buyer\CompanyResource;
use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactBranchResource extends JsonResource
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
                'phone_number' => $this->resource->phone_number,
                'detail_address' => $this->resource->detail_address,
            ],
            'relationships' => [
                'company' => new CompanyResource($this->whenLoaded('company')),
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
            ],
        ];
    }
}
