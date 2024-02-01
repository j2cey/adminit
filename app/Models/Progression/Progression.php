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
 * @property string $process_name
 * @property integer $nb_todo
 * @property integer $nb_done
 * @property integer $nb_passed
 * @property integer $rate
 * @property integer $rate_passed
 * @property boolean $exec_done
 * @property string $current_step
 *
 * @property string|null $description
 * @property integer|null $upper_progression_id
 * @property integer|null $lastprogressionstep_id
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
 * @property ProgressionStep[] $progressionsteps
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
        //$msg = "Progression, setUpperProgression for (" . $this->id . ") - upperprogression: " . (is_null($upperprogression) ? "NULL" : $upperprogression->id);
        //\Log::info($msg);
        $this->upperprogression()->associate($upperprogression)->save();
        $upperprogression->addNewSubprogressionAsToDo($this);
    }
    public function setLastProgressionStep(ProgressionStep $last_progressionstep) {
        $this->setCurrentStep($last_progressionstep->name);
        $this->lastprogressionstep()->associate($last_progressionstep)->save();
    }

    public function addNewSubprogressionAsToDo(Progression $subprogression) {
        $this->addTodo(1, "sub-progression: " . $subprogression->id);
    }

    public function addTodo(int $amount, string $name) {
        $this->update(['nb_todo' => $this->nb_todo+= $amount,]
        );
        $this->setProgressionUpToDate();
        $this->appendToDos($name);

        $this->upperprogression?->addTodo($amount, $name);
    }

    public function setCurrentStep(string $name) {
        $this->update(['current_step' => $name,]
        );
    }

    public function addStepDone(string $name, bool $passed, string|null $description, Progression|null $sub_progression) {
        $this->incrementDone($passed);

        if ( is_null($sub_progression) ) {
            $last_progressionstep = ProgressionStep::createNew($this, $name, $passed, $description, null);
        } else {
            $last_progressionstep = $sub_progression->lastprogressionstep;
            if ($sub_progression->exec_done) {
                if ( $this->progressionsteps()->where('sub_progression_id', $sub_progression->id)->count() === 0 ) {
                    ProgressionStep::createNew($this, "sub-progression " . $sub_progression->id . " executed.", true, null, $sub_progression);
                    $this->incrementDone($passed);
                }
            }
        }

        $this->setLastProgressionStep($last_progressionstep);
        $this->setProgressionUpToDate();
        $this->upperprogression?->addStepDone($name, $passed, $description, $this);
    }

    private function incrementDone(bool $passed) {
        $this->addNbDone(1);
        if ( $passed ) $this->addNbPassed(1);
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

    private function appendToDos(string $name) {
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

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->progressionsteps()->each(function($progressionstep) {
                $progressionstep->delete(); // <-- direct deletion
            });

            $model->subprogressions()->each(function($subprogression) {
                $subprogression->delete(); // <-- direct deletion
            });
        });
    }
}
