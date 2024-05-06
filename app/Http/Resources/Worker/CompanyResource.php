<?php

namespace App\Http\Resources\Worker;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
                'representative' => $this->resource->representative,
                'detail_address' => $this->resource->detail_address,
                'phone_number' => $this->resource->phone_number,
                'homepage_url' => $this->resource->homepage_url,
                'contact_person' => $this->resource->contact_person,
                'contact_email' => $this->resource->contact_email,
                'contact_phone_number' => $this->resource->contact_phone_number,
            ],
            'relationships' => [
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
            ],
        ];
    }
}
