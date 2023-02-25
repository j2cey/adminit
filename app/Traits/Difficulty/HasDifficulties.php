<?php

namespace App\Traits\Difficulty;

use App\Models\Difficulty;

trait HasDifficulties
{
    public static function bootHasDifficulties()
    {
        // after creating the model
        static::created(function ($model) {
            $model->code = $model->addDefaultDifficulty();
        });
    }

    public function difficulties() {
        $elem_type = get_called_class();
        return $this->belongsToMany(Difficulty::class, 'model_has_difficulties', 'model_id', 'difficulty_id')
            ->wherePivot('model_type', $elem_type)
            ->withPivot('model_type','model_id','posi')
            ->withTimestamps()
            ->orderBy('posi','asc');
    }

    public function addDefaultDifficulty() {
        $default_difficulty = Difficulty::default()->first();
        $this->addDifficulty($default_difficulty);
    }

    public function addDifficulty($difficulty)
    {
        if ( is_null($difficulty) ) {
            return false;
        }

        $elem_type = get_called_class();

        $difficulties_count = $this->difficulties()->count();

        if ($difficulties_count > 0) {
            $this->removeDifficulties();
            $difficulties_count = 0;
        }

        $this->difficulties()->attach($difficulty->id, [
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'posi' => $difficulties_count,
        ]);
        return true;
    }

    public function syncDifficulty($ids) {
        if (is_array($ids)) {
            $this->difficulties()->sync($ids);
            return true;
        }
        return false;
    }

    public function removeDifficulty($difficulty) {
        $this->difficulties()->detach($difficulty->id);
    }

    public function removeDifficulties() {
        $this->difficulties()->detach();
    }
}
