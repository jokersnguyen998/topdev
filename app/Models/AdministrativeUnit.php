<?php

namespace App\Models;

use App\Enums\AdministrativeUnitType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdministrativeUnit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * The administrative unit is the commune, ward, town
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeWards(Builder $builder): Builder
    {
        return $builder->whereIn('type', AdministrativeUnitType::wards());
    }

    /**
     * The administrative unit is the province and city
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeProvinces(Builder $builder): Builder
    {
        return $builder->whereIn('type', AdministrativeUnitType::provinces());
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function district(): BelongsTo
    {
        return $this->belongsTo(AdministrativeUnit::class, 'parent_id', 'id')
            ->whereIn('type', AdministrativeUnitType::districts());
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(AdministrativeUnit::class, 'parent_id', 'id')
            ->whereIn('type', AdministrativeUnitType::provinces());
    }
}
