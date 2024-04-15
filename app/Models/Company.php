<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

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
        'hash_url'
    ];

    public function casts(): array
    {
        return [
            'suspended_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Company $company) {
            $company->number = time();
        });
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
