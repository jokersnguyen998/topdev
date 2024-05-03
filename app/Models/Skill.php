<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'worker_id',
        'work_summary',
        'specialty',
        'tools',
        'self_promotion',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'worker_id', 'id');
    }

    public function jobCareers(): HasMany
    {
        return $this->hasMany(JobCareer::class, 'skill_id', 'id');
    }
}
