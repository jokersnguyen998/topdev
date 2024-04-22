<?php

namespace App\Http\Resources\Buyer_Seller;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyJobIntroductionLicenseResource extends JsonResource
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
                'license_number_1' => $this->resource->license_number_1,
                'license_number_2' => $this->resource->license_number_2,
                'license_number_3' => $this->resource->license_number_3,
                'license_number' => $this->resource->license_number,
                'license_url' => $this->resource->license_url,
                'issue_date' => $this->resource->issue_date,
                'expired_date' => $this->resource->expired_date,
                'is_excellent_referral' => $this->resource->is_excellent_referral,
                'detail_url' => $this->resource->detail_url,
                'detail_address' => $this->resource->detail_address,
            ],
            'relationships' => [
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
            ]
        ];
    }
}
