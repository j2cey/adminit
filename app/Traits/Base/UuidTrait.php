<?php

namespace App\Traits\Base;

use Illuminate\Support\Str;

trait UuidTrait
{
    public static function generateUuid()
    {
        return Str::orderedUuid();
    }
}
