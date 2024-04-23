<?php

namespace App\Models;

use App\Traits\HasAdministrativeUnit;
use App\Traits\HasNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes, HasAdministrativeUnit, HasNumber;

    protected $fillable = [
        'ward_id',
        'number',
        'name',
        'representative',
        'detail_address',
        'phone_number',
        'homepage_url',
        'contact_person',
        'contact_email',
        'contact_phone_number',
        'suspended_at',
    ];

    protected $appends = [
        'hash_url',
    ];

    /**
     * Set number field length
     *
     * @var int
     */
    protected $numberLength = 20;

    public function casts(): array
    {
        return [
            'suspended_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getHashUrlAttribute(): string
    {
        return base64_encode($this->contact_email);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function companyJobIntroductionLicense(): HasOne
    {
        return $this->hasOne(CompanyJobIntroductionLicense::class, 'company_id', 'id');
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class, 'company_id', 'id');
    }

    public function employees(): HasManyThrough
    {
        return $this->hasManyThrough(
            Employee::class,
            Branch::class,
            'company_id',
            'branch_id',
            'id',
            'id'
        );
    }
}
