<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });

    }
}
