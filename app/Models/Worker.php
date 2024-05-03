<?php

namespace App\Models;

use App\Enums\AdministrativeUnitType;
use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class Worker extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasAdministrativeUnit;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ward_id',
        'contact_ward_id',
        'name',
        'email',
        'password',
        'phone_number',
        'gender',
        'birthday',
        'detail_address',
        'avatar_url',
        'contact_detail_address',
        'contact_phone_number',
        'terms_of_use_agreement_at',
        'privacy_policy_agreement_at',
        'withdrawn_at',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'age',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */
    public function getGenderAttribute($value)
    {
        return $value ? 'Male' : 'Female';
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birthday)->age;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Doesn't withdrawn from the system
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeDoesntWithdrawn(Builder $builder): Builder
    {
        return $builder->whereNull('withdrawn_at');
    }

    /**
     * Withdrawn from the system
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeWithdrawn(Builder $builder): Builder
    {
        return $builder->whereNull('withdrawn_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function contactWard(): BelongsTo
    {
        return $this->belongsTo(AdministrativeUnit::class, 'contact_ward_id', 'id')->wards();
    }

    public function academicLevels(): HasMany
    {
        return $this->hasMany(AcademicLevel::class, 'worker_id', 'id');
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(AcademicLevel::class, 'worker_id', 'id');
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class, 'worker_id', 'id');
    }

    public function skill(): HasOne
    {
        return $this->hasOne(Skill::class, 'worker_id', 'id');
    }
}
