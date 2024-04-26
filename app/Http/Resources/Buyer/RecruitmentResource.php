<?php

namespace App\Http\Resources\Buyer;

use App\Http\Resources\Common\OccupationResource;
use App\Http\Resources\Common\WorkingLocationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentResource extends JsonResource
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
                'number' => $this->resource->number,
                'title' => $this->resource->title,
                'sub_title' => $this->resource->sub_title,
                'content' => $this->resource->content,
                'salary_type' => $this->resource->salary_type,
                'salary' => $this->resource->salary,
                'monthly_salary' => $this->resource->monthly_salary,
                'yearly_salary' => $this->resource->yearly_salary,
                'has_referral_fee' => $this->resource->has_referral_fee,
                'referral_fee_type' => $this->resource->referral_fee_type,
                'referral_fee_note' => $this->resource->referral_fee_note,
                'referral_fee_by_value' => $this->resource->referral_fee_by_value,
                'referral_fee_percent' => $this->resource->referral_fee_percent,
                'referral_fee_by_percent' => $this->resource->referral_fee_by_percent,
                'has_refund' => $this->resource->has_refund,
                'refund_note' => $this->resource->refund_note,
                'contact_email' => $this->resource->contact_email,
                'contact_phone_number' => $this->resource->contact_phone_number,
                'holiday' => $this->resource->holiday,
                'welfare' => $this->resource->welfare,
                'employment_type' => $this->resource->employment_type,
                'employment_note' => $this->resource->employment_note,
                'labor_contract_type' => $this->resource->labor_contract_type,
                'video_url' => $this->resource->video_url,
                'image_1_url' => $this->resource->image_1_url,
                'image_2_url' => $this->resource->image_2_url,
                'image_3_url' => $this->resource->image_3_url,
                'image_1_caption' => $this->resource->image_1_caption,
                'image_2_caption' => $this->resource->image_2_caption,
                'image_3_caption' => $this->resource->image_3_caption,
            ],
            'relationships' => [
                'contact_branch' => new ContactBranchResource($this->whenLoaded('branch')),
                'contact_employee' => new ContactEmployeeResource($this->whenLoaded('employee')),
                'occupations' => OccupationResource::collection($this->whenLoaded('occupations')),
                'working_locations' => WorkingLocationResource::collection($this->whenLoaded('workingLocations')),
            ],
        ];
    }
}
