<?php

namespace App\Models\Progression;

use App\Models\Status;
use App\Jobs\ProgressionJob;
use App\Contracts\Progression\IHasProgression;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property Progression $progression
 */
trait HasProgression
{
    abstract public function getUpperHasProgression(): ?IHasProgression;

    /**
     * @return MorphOne
     */
    public function progression()
    {
        return $this->morphOne(Progression::class, 'hasprogression');
    }

    public function setProgression(int $nb_todo = null, string $description = null, Status $status = null): ?Progression {
        $data = [];
        $data['nb_todo'] = $nb_todo ?? 0;
        if ( ! is_null($description) ) $data['description'] = $description;
        if ( is_null( $this->progression ) ) {
            $progression = Progression::createNew($data);

            $this->progression()->save($progression);
            $this->setUpperProgression($this->getUpperHasProgression()?->progression);

            if ( ! is_null($status) ) $progression->status()->associate($status);

            return $progression;
        }
        return null;
    }

    public function setUpperProgression(Progression|null $progression) {
        $msg = "HasProgression, setUpperProgression for " . self::class . "(" . $this->id . ") - upperprogression: " . ( is_null($progression) ? "NULL" : $progression->id );
        \Log::info($msg);
        if ( is_null( $this->progression ) ) {
            $this->refresh();
        }
        if ( is_null($progression) ) {
            return;
        }
        $this->progression?->setUpperProgression($progression);
    }

    #region Custom Functions
    public function progressionAddTodo(int $amount, string $name) {
        dispatch(new ProgressionJob($this->progression, "addTodo", ['amount' => $amount, 'name' => $name,]));
        return $this->progression;
    }
    public function progressionAddStepDone(string $name, bool $passed, string|null $description) {
        dispatch(new ProgressionJob($this->progression, "addStepDone", ['name' => $name,'passed' => $passed,'description' => $description, 'child_progression' => null,]));
        return $this->progression;
    }
    #endregion

    protected function initializeHasProgression()
    {
        $this->with = array_unique(array_merge($this->with, ['progression']));
    }

    public static function bootHasProgression()
    {
        // after the model has been created
        static::created(function ($model) {
            // We rebuild the whole path
            $model->setProgression();
        });

        // when deleting the model
        static::deleting(function ($model) {
            // We rebuild the whole path
            $model->progression->delete();
        });
    }
}
