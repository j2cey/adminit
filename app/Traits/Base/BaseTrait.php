<?php

namespace App\Traits\Base;


trait BaseTrait
{
    use Uuidable, StatusTrait;

    public static function bootBaseTrait()
    {
        static::saving(function ($model) {
            $model->setDefaultStatus();
        });
    }
}
