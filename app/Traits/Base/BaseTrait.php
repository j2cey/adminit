<?php

namespace App\Traits\Base;


trait BaseTrait
{
    use Uuidable, StatusTrait, HasDefault;

    public function removeAttributesNotInModelTable($model) {
        foreach ($model->getAttributes() as $key => $value) {
            if(!in_array($key, array_keys($model->getOriginal())))
                unset($model->$key);
        }
    }

    public static function bootBaseTrait()
    {
        static::saving(function ($model) {
            if (is_null($model->status_id)) {
                $model->setDefaultStatus();
            }
        });
    }
}
