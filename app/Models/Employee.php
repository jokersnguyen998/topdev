<?php

namespace App\Models;

use App\Traits\HasAdministrativeUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasAdministrativeUnit;

    protected $fillable = [
        'branch_id',
        'company_id',
        'ward_id',
        'name',
        'email',
        'password',
        'phone_number',
        'gender',
        'birthday',
        'detail_address',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => 'boolean',
        ];
    }
}
