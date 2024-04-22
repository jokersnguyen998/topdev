<?php

namespace App\Traits;

use App\Models\AdministrativeUnit;
use App\Models\Occupation;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasService
{
    public function serviceAreas(): MorphToMany
    {
        return $this->morphToMany(
            AdministrativeUnit::class,
            'serviceable',
            'service_areas',
            'serviceable_id',
            'area_id',
            'id',
            'id'
        );
    }

    public function serviceOccupations(): MorphToMany
    {
        return $this->morphToMany(
            Occupation::class,
            'serviceable',
            'service_occupations',
            'serviceable_id',
            'occupation_id',
            'id',
            'id'
        );
    }
}
