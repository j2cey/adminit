<?php


namespace App\Traits\Code;

use Illuminate\Support\Str;

trait HasCode
{
    public static function bootHasCode()
    {
        // before creating the model
        static::creating(function ($model) {
            $model->normalizeCodeField();
        });
    }

    /**
     * Make sure the code field is given and set it if not
     * @return void
     */
    public function normalizeCodeField() {
        if ( is_null($this->code) ) {
            $this->code = $this->generateCodeFromClassName();
        } else {
            $this->code = Str::slug($this->code, '-');
        }
    }

    public function generateCodeFromClassName(): string
    {
        $elem_type = str_replace("\\", "_", get_called_class());
        $elem_count = get_called_class()::all()->count();

        return $elem_type . "_" . $elem_count;
    }
}
