<?php

namespace App\Http\Resources\Buyer_Seller;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
                'job_introduction_license' => new BranchJobIntroductionLicenseResource($this->whenLoaded('branchJobIntroductionLicense')),
                'company' => new CompanyResource($this->whenLoaded('company')),
            ],
        ];
    }
}
