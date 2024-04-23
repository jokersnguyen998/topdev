<?php

namespace App\Http\Resources\Buyer;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->resource->id,
            'attributes' => [
                'name' => $this->resource->name,
                'email' => $this->resource->email,
                'phone_number' => $this->resource->phone_number,
                'gender' => $this->resource->gender,
                'birthday' => $this->resource->birthday,
                'age' => $this->resource->age,
                'detail_address' => $this->resource->detail_address,
            ],
            'relationships' => [
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
            ],
        ];
    }
}
