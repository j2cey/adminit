<?php

namespace App\Traits\Appreciation;

use App\Models\Appreciation;

trait HasAppreciations
{
    public static function bootHasAppreciations()
    {
        // after creating the model
        static::created(function ($model) {
            $model->code = $model->addDefaultAppreciation();
        });
    }

    public function appreciations() {
        $elem_type = get_called_class();
        return $this->belongsToMany(Appreciation::class, 'model_has_appreciations', 'model_id', 'appreciation_id')
            ->wherePivot('model_type', $elem_type)
            ->withPivot('model_type','model_id','posi')
            ->withTimestamps()
            ->orderBy('posi','asc');
    }

    public function addDefaultAppreciation() {
        $default_appreciation = Appreciation::default()->first();
        $this->addAppreciation($default_appreciation);
    }

    public function addAppreciation($appreciation)
    {
        if ( is_null($appreciation) ) {
            return false;
        }

        $elem_type = get_called_class();

        $appreciations_count = $this->appreciations()->count();

        if ($appreciations_count > 0) {
            $this->removeAppreciations();
            $appreciations_count = 0;
        }

        $this->appreciations()->attach($appreciation->id, [
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'posi' => $appreciations_count,
        ]);
        return true;
    }

    public function syncAppreciation($ids) {
        if (is_array($ids)) {
            $this->appreciations()->sync($ids);
            return true;
        }
        return false;
    }

    public function removeAppreciation($appreciation) {
        $this->appreciations()->detach($appreciation->id);
    }

    public function removeAppreciations() {
        $this->appreciations()->detach();
    }
}
