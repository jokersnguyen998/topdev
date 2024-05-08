<?php

namespace App\Models;

use App\Traits\RelationshipsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
    use HasFactory, SoftDeletes, RelationshipsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'contact_branch_id',
        'contact_employee_id',
        'is_published',
        'publish_start_date',
        'publish_end_date',
        'number',
        'title',
        'sub_title',
        'content',
        'salary_type',
        'salary',
        'monthly_salary',
        'yearly_salary',
        'has_referral_fee',
        'referral_fee_type',
        'referral_fee_note',
        'referral_fee_by_value',
        'referral_fee_percent',
        'referral_fee_by_percent',
        'has_refund',
        'refund_note',
        'contact_email',
        'contact_phone_number',
        'holiday',
        'welfare',
        'employment_type',
        'employment_note',
        'labor_contract_type',
        'video_url',
        'image_1_url',
        'image_2_url',
        'image_3_url',
        'image_1_caption',
        'image_2_caption',
        'image_3_caption',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'has_referral_fee' => 'boolean',
            'has_refund' => 'boolean',
            'publish_start_date' => 'date:Y-m-d',
            'publish_end_date' => 'date:Y-m-d',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeRevised(Builder $query): Builder
    {
        return $query
                ->join('latest_recruitments', 'latest_recruitments.recruitment_id', '=', 'recruitments.id')
                ->select('recruitments.*');
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

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'contact_branch_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'contact_employee_id', 'id');
    }

    public function occupations(): BelongsToMany
    {
        return $this->belongsToMany(
            Occupation::class,
            'recruitment_occupations',
            'recruitment_id',
            'occupation_id',
            'id',
            'id',
        );
    }

    public function workingLocations(): BelongsToMany
    {
        return $this->belongsToMany(
            AdministrativeUnit::class,
            'working_locations',
            'recruitment_id',
            'ward_id',
            'id',
            'id',
        )->withPivot(['detail_address', 'map_url', 'note']);
    }
}
