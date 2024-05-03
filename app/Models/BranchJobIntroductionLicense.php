<?php

namespace App\Models;

use App\Traits\HasAdministrativeUnit;
use App\Traits\HasService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchJobIntroductionLicense extends Model
{
    use HasFactory, HasAdministrativeUnit, HasService;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch_id',
        'ward_id',
        'detail_address',
        'license_url',
        'detail_url',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
