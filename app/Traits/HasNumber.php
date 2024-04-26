<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait HasNumber
{
    protected static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (is_null($model->number)) {
                $model->number = Str::random($model->numberLength ?? 20);
            }
        });
    }
}

