<?php

namespace App\Models\ReportTreatments;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Enums\TreatmentStepCode;
use App\Enums\TreatmentStateEnum;
use App\Enums\TreatmentResultEnum;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportTreatmentResult
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $result
 * @property string $state
 * @property string $message
 *
 * @property string $description
 *
 * @property int $currentstep_num
 * @property int $currentstep_id
 * @property int $report_id
 *
 * @property string|null $hasreporttreatmentresults_type
 * @property int|null $hasreporttreatmentresults_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property ReportTreatmentStepResult $currentstep
 * @property ReportTreatmentStepResult[] $reporttreatmentsteps
 *
 * @method static ReportTreatmentResult create(string[] $array)
 */
class ReportTreatmentResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
        'result' => TreatmentResultEnum::class,
        'state' => TreatmentStateEnum::class,
    ];

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

    #region Scopes

    public function scopeWaiting($query) {
        return $query
            ->where('state', TreatmentStateEnum::WAITING->value);
    }

    public function scopeNotCompleted($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function scopeNotRunning($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::RUNNING->value]);
    }

    public function scopeNotQueued($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::QUEUED->value]);
    }

    #endregion

    #region Eloquent Relationships

    public function reporttreatmentsteps() {
        return $this->hasMany(ReportTreatmentStepResult::class, "report_treatment_result_id");
    }

    public function currentstep() {
        return $this->belongsTo(ReportTreatmentStepResult::class, "currentstep_id");
    }

    #endregion

    #region Custom Functions

    public static function createNew(
        string $name = null, Model|ReportTreatmentStepResult $currentstep = null,
        Carbon $start_at = null, Carbon $end_at = null,
        TreatmentStateEnum $state = null, TreatmentResultEnum $result = null,
        string $description = null): ReportTreatmentResult
    {
        $reporttreatmentresult = ReportTreatmentResult::create([
            'name' => $name,
            'start_at' => $start_at ?? Carbon::now(),
            'end_at' => $end_at ?? Carbon::now(),
            'state' => $state ? $state->value : TreatmentStateEnum::WAITING->value,
            'result' => $result ? $result->value : TreatmentResultEnum::NONE->value,
            'description' => $description,
        ]);

        if ( ! is_null($currentstep) ) $reporttreatmentresult->currentstep()->associate($currentstep);

        $reporttreatmentresult->save();

        return $reporttreatmentresult;
    }

    public function updateThis(
        string $name = null,
        Model|ReportTreatmentStepResult $currentstep = null, int $currentstep_num = null,
        Carbon $start_at = null, Carbon $end_at = null,
        TreatmentStateEnum $state = null, TreatmentResultEnum $result = null, string $description = null): ReportTreatmentResult
    {
        $this->name = $name;
        $this->start_at = $start_at ?? Carbon::now();
        $this->end_at = $end_at ?? Carbon::now();
        $this->state = $state ? $state->value : TreatmentStateEnum::WAITING->value;
        $this->result = $result ? $result->value : TreatmentResultEnum::NONE->value;
        $this->currentstep_num = $currentstep_num;
        $this->description = $description;

        if ( ! is_null($currentstep) ) $this->currentstep()->associate($currentstep);

        $this->save();

        return $this;
    }

    public function addStep(TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false) {

        $step = ReportTreatmentStepResult::createNew($code, $name,$this,null,null,null,null, $criticality_level);
        if ( $set_as_current_step ) {
            $this->setCurrentStep($step);
        }

        return $step;
    }

    public function setCurrentStep(Model|ReportTreatmentStepResult $currentstep) {
        $this->currentstep()->associate($currentstep);

        return $this->currentstep;
    }

    public function goToNextStep() {
        $this->currentstep_num += 1;
        return $this->save();
    }

    public function setQueued() {
        $this->state = TreatmentStateEnum::QUEUED;
        $this->save();
    }

    public function setRunning() {
        $this->state = TreatmentStateEnum::RUNNING;
        $this->save();
    }

    public function setWaiting() {
        $this->state = TreatmentStateEnum::WAITING;
        $this->save();
    }

    public function stepComplted(Model|ReportTreatmentStepResult $step) {
        $this->result = $step->result;
        $this->message = $step->message;
        $this->setWaiting();
    }

    public function setEnd() {
        $this->end_at = Carbon::now();
        $this->state = TreatmentStateEnum::COMPLETED;
        $this->save();
    }

    #endregion
}
