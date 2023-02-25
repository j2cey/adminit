<?php

namespace App\Traits\Priority;

use App\Models\Priority;

trait HasPriorities
{
    public static function bootHasPriorities()
    {
        // after creating the model
        static::created(function ($model) {
            $model->code = $model->addDefaultPriority();
        });
    }

    public function priorities() {
        $elem_type = get_called_class();
        return $this->belongsToMany(Priority::class, 'model_has_priorities', 'model_id', 'priority_id')
            ->wherePivot('model_type', $elem_type)
            ->withPivot('model_type','model_id','posi')
            ->withTimestamps()
            ->orderBy('posi','asc');
    }

    public function addDefaultPriority() {
        $default_priority = Priority::default()->first();
        $this->addPriority($default_priority);
    }

    public function addPriority($priority)
    {
        if ( is_null($priority) ) {
            return false;
        }

        $elem_type = get_called_class();

        $priorities_count = $this->priorities()->count();

        if ($priorities_count > 0) {
            $this->removePriorities();
            $priorities_count = 0;
        }

        $this->priorities()->attach($priority->id, [
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'posi' => $priorities_count,
        ]);
        return true;
    }

    public function syncPriority($ids) {
        if (is_array($ids)) {
            $this->priorities()->sync($ids);
            return true;
        }
        return false;
    }

    public function removePriority($priority) {
        $this->priorities()->detach($priority->id);
    }

    public function removePriorities() {
        $this->priorities()->detach();
    }
}
