<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait HasNumber
{
    protected static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->number = Str::random($model->numberLength ?? 20);
        });
    }
}

