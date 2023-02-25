<?php


namespace App\Traits\Base;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\This;

/**
 * Trait HasDefault
 * @package App\Traits\Base
 *
 * @property integer $id
 * @property boolean $is_default
 */
trait HasDefault
{
    public function setDefault($new_val = 1) {

        // Get the object with this default (new) value
        $olddefault = $this->getDefault($new_val, [$this->id]);
        $old_val = $this->is_default;

        $this->update(['is_default' => $new_val]);
        if ($olddefault) {
            $olddefault->setDefault($old_val);
        }

        return $this;
    }

    public function unsetDefault($id) {
        $model_type = get_called_class();
        $curr_default = $this->getDefault();

        if ($id === $curr_default->id) {
            $min_obj = $model_type::orderBy('id', 'ASC')->whereNotIn('id', [$id])->first();
            if ($min_obj) {
                $min_obj->setDefault();
            }
        }
    }

    public static function getDefault($val = 1, $exclude = []) {
        $model_type = get_called_class();
        return $model_type::where('is_default', $val)->whereNotIn('id', $exclude)->first();
    }

    public static function bootHasDefault()
    {
        static::deleting(function ($model) {
            // TODO: manage unsetDefault on deleting
            //$model->unsetDefault($model->id);
        });
    }
}
