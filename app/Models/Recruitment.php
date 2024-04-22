<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
    use HasFactory, SoftDeletes;

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

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
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
