<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralConnection extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'worker_id',
        'published_resume_at',
        'published_experience_at',
        'requested_to_enter_resume_at',
        'completed_resume_at',
        'is_first',
        'memo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_resume_at' => 'datetime',
            'published_experience_at' => 'datetime',
            'requested_to_enter_resume_at' => 'datetime',
            'completed_resume_at' => 'datetime',
            'is_first' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Publish resume
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopePublishedResume(Builder $builder): Builder
    {
        return $builder->whereNotNull('published_resume_at');
    }

    /**
     * Don't publish resume
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeNotPublishedResume(Builder $builder): Builder
    {
        return $builder->whereNull('published_resume_at');
    }

    /**
     * Publish experience
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopePublishedExperience(Builder $builder): Builder
    {
        return $builder->whereNotNull('published_experience_at');
    }

    /**
     * Don't publish experience
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeNotPublishedExperience(Builder $builder): Builder
    {
        return $builder->whereNull('published_experience_at');
    }

    /**
     * Requested to enter resume
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeRequestedToEnterResume(Builder $builder): Builder
    {
        return $builder->whereNotNull('requested_to_enter_resume_at');
    }

    /**
     * Completed resume
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function scopeCompletedResume(Builder $builder): Builder
    {
        return $builder->whereNotNull('completed_resume_at');
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

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'worker_id', 'id');
    }
}
