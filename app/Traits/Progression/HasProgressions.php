<?php

namespace App\Traits\Progression;

use App\Models\Progression;

trait HasProgressions
{
    public function progressions() {
        $elem_type = get_called_class();
        return $this->hasMany(Progression::class, 'model_id', 'id')
            ->where('model_type', $elem_type)
            ->orderBy('created_at','asc');
    }

    public function addProgression($nb_todo)
    {
        if ( is_null($nb_todo) ) {
            return false;
        }

        $elem_type = get_called_class();

        return $this->progressions()->create([
            'nb_todo' => $nb_todo,
            'model_type' => $elem_type,
            'model_id' => $this->id,
        ]);
    }
}
