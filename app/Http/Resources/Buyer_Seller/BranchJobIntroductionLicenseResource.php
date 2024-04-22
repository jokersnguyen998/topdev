<?php

namespace App\Http\Resources\Buyer_Seller;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchJobIntroductionLicenseResource extends JsonResource
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
            'attrubutes' => [
                'license_url' => $this->resource->license_url,
                'detail_url' => $this->resource->detail_url,
                'detail_address' => $this->resource->detail_address,
            ],
            'relationships' => [
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
            ]
        ];
    }
}
