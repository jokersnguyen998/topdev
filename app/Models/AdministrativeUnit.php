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

    public function scopeWards(Builder $builder): Builder
    {
        return $builder->whereIn('type', AdministrativeUnitType::wards());
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
