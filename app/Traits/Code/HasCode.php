<?php


namespace App\Traits\Code;

trait HasCode
{
    public static function bootHasCode()
    {
        // before creating the model
        static::creating(function ($model) {
            $model->code = $model->generateCodeFromClassName();
        });
    }

    public function generateCodeFromClassName() {
        $elem_type = str_replace("\\", "_", get_called_class());
        $elem_count = get_called_class()::all()->count();

        return $elem_type . "_" . $elem_count;
    }
}
