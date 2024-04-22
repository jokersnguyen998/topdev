<?php

namespace App\Models;

use App\Traits\HasAdministrativeUnit;
use App\Traits\HasService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyJobIntroductionLicense extends Model
{
    use HasFactory, HasAdministrativeUnit, HasService;

    protected $fillable = [
        'company_id',
        'ward_id',
        'license_number_1',
        'license_number_2',
        'license_number_3',
        'license_url',
        'issue_date',
        'expired_date',
        'is_excellent_referral',
        'detail_url',
        'detail_address',
    ];

    protected $appends = [
        'license_number',
    ];

    public function casts(): array
    {
        return [
            'issue_date' => 'date:Y-m-d',
            'expired_date' => 'date:Y-m-d',
            'is_excellent_referral' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getLicenseNumberAttribute(): string
    {
        return "{$this->license_number_1}-{$this->license_number_2}-{$this->license_number_3}";
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
