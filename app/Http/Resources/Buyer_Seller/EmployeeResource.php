<?php

namespace App\Http\Resources\Buyer_Seller;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
                'email' => $this->resource->email,
                'phone_number' => $this->resource->phone_number,
                'birthday' => $this->resource->birthday,
                'age' => $this->resource->age,
                'gender' => $this->resource->gender,
                'detail_address' => $this->resource->detail_address,
            ],
            'relationships' => [
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
                'branch' => new BranchResource($this->whenLoaded('branch')),
                'company' => new CompanyResource($this->whenLoaded('company')),
            ],
        ];
    }
}
