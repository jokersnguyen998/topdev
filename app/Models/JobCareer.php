<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCareer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'skill_id',
        'company_name',
        'department_name',
        'year',
        'month',
        'is_retired',
        'environment',
        'role',
        'technique',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'is_retired' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }
}
