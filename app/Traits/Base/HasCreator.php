<?php

namespace App\Traits\Base;

use Illuminate\Support\Facades\Auth;

trait HasCreator
{
    public static function bootHasCreator()
    {
        static::creating(function($model)
        {
            $user = Auth::user();
            if ($user) {
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            }
        });

        static::updating(function($model)
        {
            $user = Auth::user();
            if ($user) {
                $model->updated_by = $user->id;
            }
        });
    }
}
