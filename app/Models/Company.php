<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function casts(): array
    {
        return [
            'suspended_at' => 'datetime',
        ];
    }
}
