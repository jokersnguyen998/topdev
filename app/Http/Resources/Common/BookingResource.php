<?php

namespace App\Http\Resources\Common;

use App\Http\Resources\Buyer_Seller\BranchResource;
use App\Http\Resources\Buyer_Seller\CompanyResource;
use App\Http\Resources\Buyer_Seller\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
                'start_time' => $this->resource->start_time,
                'end_time' => $this->resource->end_time,
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
                'branch' => new BranchResource($this->whenLoaded('branch')),
                'employee' => new EmployeeResource($this->whenLoaded('employee')),
            ],
        ];
    }
}
