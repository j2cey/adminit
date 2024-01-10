<?php

namespace App\Models\Progression;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Progression
 * @package App\Models\Progression
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property integer $nb_todo
 * @property integer $nb_done
 * @property integer $nb_passed
 * @property integer $rate
 * @property integer $rate_passed
 * @property boolean $exec_done
 *
 * @property string|null $description
 * @property integer|null $upper_progression_id
 *
 * @property string|null $hasprogression_type
 * @property integer|null $hasprogression_id
 * @property string|null $todos
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Progression|null $upperprogression
 * @property ProgressionStep|null $lastprogressionstep
 * @property Progression[] $subprogressions
 * @method static Progression create(array $array)
 */
class Progression extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [

        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [

        ];
    }

    #endregion

    #region Eloquent Relationships
    /**
     * @return MorphTo
     */
    public function hasprogression()
    {
        return $this->morphTo();
    }

    public function upperprogression() {
        return $this->belongsTo(Progression::class, "upper_progression_id");
    }
    public function subprogressions() {
        return $this->hasMany(Progression::class, "upper_progression_id");
    }
    public function progressionsteps() {
        return $this->hasMany(ProgressionStep::class, "progression_id");
    }
    public function lastprogressionstep() {
        return $this->belongsTo(ProgressionStep::class, "lastprogressionstep_id");
    }
    #endregion

    #region Custom Functions
    /**
     * @param array|null $array
     * @return Progression
     */
    public static function createNew(array $array = null): Progression
    {
        return Progression::create($array);
    }

    public function setUpperProgression(Progression|null $upperprogression) {
        $msg = "Progression, setUpperProgression for (" . $this->id . ") - upperprogression: " . (is_null($upperprogression) ? "NULL" : $upperprogression->id);
        \Log::info($msg);
        $this->upperprogression()->associate($upperprogression)->save();
    }
    public function setLastProgressionStep(ProgressionStep $last_progressionstep) {
        $this->lastprogressionstep()->associate($last_progressionstep)->save();
    }

    public function addTodo(int $amount, string $name) {
        $this->update(['nb_todo' => $this->nb_todo+= $amount,]
        );
        $this->setProgressionUpToDate();
        $this->addToDos($name);

        $this->upperprogression?->addTodo($amount, $name);
    }

    public function addStepDone(string $name, bool $passed, string|null $description, Progression|null $child_progression) {
        $this->addNbDone(1);
        if ( $passed ) $this->addNbPassed(1);

        if ( is_null($child_progression) ) {
            $last_progressionstep = ProgressionStep::createNew($this, $name, $passed, $description);
        } else {
            $last_progressionstep = $child_progression->lastprogressionstep;
        }

        $this->setLastProgressionStep($last_progressionstep);
        $this->setProgressionUpToDate();
        $this->upperprogression?->addStepDone($name, $passed, $description, $this);
    }

    public function setProgressionUpToDate() {
        $this->setRate();
        $this->setRatePassed();
        $this->setExecDone();
    }

    /**
     * @return int
     */
    public function getProgressionStepsCount(): int
    {
        $steps_count = $this->progressionsteps()->count();
        $subprogressions = $this->subprogressions;

        foreach ($subprogressions as $subprogression) {
            $steps_count += $subprogression->getProgressionStepsCount();
        }

        return $steps_count;
    }

    /**
     * @return int
     */
    public function getProgressionPassedStepsCount(): int
    {
        $steps_count = $this->progressionsteps()->where('passed', 1)->count();
        $subprogressions = $this->subprogressions;

        foreach ($subprogressions as $subprogression) {
            $steps_count += $subprogression->getProgressionPassedStepsCount();
        }

        return $steps_count;
    }

    private function addNbDone(int $amount) {
        $this->setNbDone($this->nb_done+= $amount);
    }
    private function setNbDone(int $amount) {
        $this->update(['nb_done' => $amount,]
        );
    }

    private function addNbPassed(int $amount) {
        $this->setNbPassed($this->nb_passed+= $amount);
    }
    private function setNbPassed(int $amount) {
        $this->update(['nb_passed' => $amount,]
        );
    }

    private function setRate() {
        $this->update(['rate' => $this->nb_todo === 0 ? 0 : ($this->nb_done / $this->nb_todo) * 100,]
        );
    }
    private function setRatePassed() {
        $this->update(['rate_passed' => $this->nb_todo === 0 ? 0 : ($this->nb_passed / $this->nb_todo) * 100,]
        );
    }
    private function setExecDone() {
        $this->update(['exec_done' => $this->nb_done >= $this->nb_todo,]
        );
    }

    private function addToDos(string $name) {
        $todos_arr = is_null($this->todos) ? [] : json_decode($this->todos, true);
        $todos_arr[] = ['name' => $name];

        $this->update(['todos' => json_encode($todos_arr)]);
    }

    public static function getById(int|null $id): ?Progression {
        if ( is_null($id) ) {
            return null;
        }
        return Progression::find($id);
    }
    #endregion
}
