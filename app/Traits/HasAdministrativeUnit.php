<?php

namespace App\Traits;

use App\Models\AdministrativeUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAdministrativeUnit
{
    /**
     * Query the "commune, ward, town" relationship of this model
     *
     * @return BelongsTo
     */
    public function ward(): BelongsTo
    {
        return $this->belongsTo(AdministrativeUnit::class, 'ward_id', 'id')
            ->wards();
    }

    /**
     * Query conditions by commune, ward, town
     *
     * @return Builder
     */
    public function wards(): Builder
    {
        return AdministrativeUnit::query()->wards();
    }
}

