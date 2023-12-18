<?php

namespace App\Traits\Base;

use App\Models\ModelPicker;

trait ModelPickable
{
    /**
     * @param $selection_criteria
     * @return self
     */
    public static function pick($selection_criteria) {
        $model_picked = ModelPicker::pickModel(self::class, $selection_criteria);
        if ( is_null($model_picked) ) {
            return null;
        }
        return self::find($model_picked->model_id);
    }

    public function unpick() {
        // free model picker if any
        $model_picked = ModelPicker::getPicker(self::class, $this->id);
        $model_picked?->unpickModel();
    }
}
