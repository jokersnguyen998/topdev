<?php

namespace App\Http\Resources\Worker;

use App\Http\Resources\Common\AdministrativeUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
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
                'gender' => $this->resource->gender,
                'birthday' => $this->resource->birthday,
                'age' => $this->resource->age,
                'detail_address' => $this->resource->detail_address,
                'avatar_url' => $this->resource->avatar_url,
                'contact_detail_address' => $this->resource->contact_detail_address,
                'contact_phone_number' => $this->resource->contact_phone_number,
            ],
            'relationships' => [
                'ward' => new AdministrativeUnitResource($this->whenLoaded('ward')),
                'contact_ward' => new AdministrativeUnitResource($this->whenLoaded('contactWard')),
                'academic_levels' => AcademicLevelResource::collection($this->whenLoaded('academicLevels')),
                'work_experiences' => WorkExperienceResource::collection($this->whenLoaded('workExperiences')),
                'licenses' => LicenseResource::collection($this->whenLoaded('licenses')),
                'skill' => new SkillResource($this->whenLoaded('skill')),
            ],
        ];
    }
}
