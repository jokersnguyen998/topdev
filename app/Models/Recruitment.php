<?php

namespace App\Models;

use App\Traits\HasNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
    use HasFactory, SoftDeletes, HasNumber;

    protected $fillable = [
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
     * Set number field length
     *
     * @var int
     */
    protected $numberLength = 50;

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
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'contact_branch_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'contact_employee_id', 'id');
    }
}
