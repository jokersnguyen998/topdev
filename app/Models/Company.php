<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'representative',
        'zipcode',
        'province',
        'district',
        'ward',
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
