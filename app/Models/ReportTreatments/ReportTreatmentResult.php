<?php

namespace App\Models\ReportTreatments;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Enums\TreatmentStepCode;
use App\Enums\TreatmentStateEnum;
use App\Enums\TreatmentResultEnum;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ReportTreatmentResult\IsReportTreatment;
use App\Contracts\ReportTreatmentResult\IIsReportTreatment;

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
 * @property int $attempts
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
 * @property Carbon $retry_start_at
 * @property int $retries_session_count
 * @property Carbon $retry_end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $payload
 *
 * @property Report $report
 * @property ReportTreatmentStepResult $currentstep
 * @property ReportTreatmentStepResult[] $reporttreatmentsteps
 * @property ReportTreatmentWorkflowStep $workflowstep
 *
 * @method static ReportTreatmentResult create(string[] $array)
 */
class ReportTreatmentResult extends BaseModel implements Auditable, IIsReportTreatment
{
    use HasFactory, IsReportTreatment, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['workflowstep'];
    protected $casts = [
        'result' => TreatmentResultEnum::class,
        'state' => TreatmentStateEnum::class,
        'nextstep_code' => TreatmentStepCode::class,
    ];
    protected $appends = [
        'stepsWaitingCount',
        'stepsQueuedCount',
        'stepsRunningCount',
        'stepsRetryingCount',
        'stepsSuccessCount',
        'stepsFailedCount',
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

    #region Accessors & Mutators

    public function getStepsWaitingCountAttribute() {
        return $this->reporttreatmentsteps()->waiting()->count();
    }
    public function getStepsQueuedCountAttribute() {
        return $this->reporttreatmentsteps()->queued()->count();
    }
    public function getStepsRunningCountAttribute() {
        return $this->reporttreatmentsteps()->running()->count();
    }
    public function getStepsRetryingCountAttribute() {
        return $this->reporttreatmentsteps()->retrying()->count();
    }
    public function getStepsSuccessCountAttribute() {
        return $this->reporttreatmentsteps()->success()->completed()->count();
    }
    public function getStepsFailedCountAttribute() {
        return $this->reporttreatmentsteps()->failed()->waiting()->count();
    }


    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    public function report() {
        return $this->belongsTo(Report::class, "report_id");
    }

    public function reporttreatmentsteps() {
        return $this->hasMany(ReportTreatmentStepResult::class, "report_treatment_result_id");
    }

    public function currentstep() {
        return $this->belongsTo(ReportTreatmentStepResult::class, "currentstep_id");
    }

    public function runningsteps() {
        return $this->reporttreatmentsteps()->running();
    }

    public function workflowstep() {
        return $this->belongsTo(ReportTreatmentWorkflowStep::class, "workflow_step_id");
    }

    #endregion

    #region Custom Functions

    /**
     * Create a new ReportTreatmentResult object
     * @param Model|Report $report
     * @param string|null $name
     * @param Model|ReportTreatmentStepResult|null $currentstep
     * @param string|null $description
     * @return ReportTreatmentResult
     */
    public static function createNew(
        Model|Report $report,
        string $name = null, Model|ReportTreatmentStepResult $currentstep = null,
        string $description = null): ReportTreatmentResult
    {
        $reporttreatmentresult = ReportTreatmentResult::create([
            'name' => $name,
            'state' => TreatmentStateEnum::WAITING->value,
            'result' => TreatmentResultEnum::NONE->value,
            'currentstep_num' => 0,
            'description' => $description,
        ]);

        $reporttreatmentresult->report()->associate($report);

        if ( ! is_null($currentstep) ) $reporttreatmentresult->currentstep()->associate($currentstep);

        $reporttreatmentresult->workflowstep()->associate($reporttreatmentresult->report->treatmentworkflow->firstworkflowstep);

        $reporttreatmentresult->save();

        return $reporttreatmentresult;
    }

    /**
     * Update this ReportTreatmentResult object
     * @param string|null $name
     * @param Model|ReportTreatmentStepResult|null $currentstep
     * @param int|null $currentstep_num
     * @param Carbon|null $start_at
     * @param Carbon|null $end_at
     * @param TreatmentStateEnum|null $state
     * @param TreatmentResultEnum|null $result
     * @param string|null $description
     * @return $this
     */
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

    /**
     * Add a step to this treatments.
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param CriticalityLevelEnum|null $criticality_level
     * @param bool $set_as_current_step
     * @return ReportTreatmentStepResult
     */
    public function addStep(TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false): ReportTreatmentStepResult
    {
        $step = ReportTreatmentStepResult::createNew($code, $name,$this,$criticality_level);
        if ( $set_as_current_step ) {
            $this->setCurrentStep($step);
        }

        return $step;
    }

    /**
     * Set a step as current step
     * @param Model|ReportTreatmentStepResult $currentstep
     * @return ReportTreatmentStepResult
     */
    public function setCurrentStep(Model|ReportTreatmentStepResult $currentstep): ReportTreatmentStepResult
    {
        $this->goToNextStep();
        $this->currentstep()->associate($currentstep);

        $this->save();

        return $this->currentstep;
    }

    /**
     * Go to next step
     * @return bool
     */
    public function goToNextStep(): bool
    {
        $this->currentstep_num += 1;
        return $this->save();
    }

    /**
     * Start the treatment of this ReportTreatmentStepResult object
     * @return void
     */
    public function startTreatment(Model|ReportTreatmentStepResult $step = null) {
        $this->setStarting(true);
        $this->setRunningOrRetrying(true);
    }

    /**
     * Can be called when a step is started so this Treatment's state got updated as well
     * @param Model|ReportTreatmentStepResult $step
     * @return void
     */
    public function stepStarted(Model|ReportTreatmentStepResult $step) {
        $this->startTreatment($step);
    }

    /**
     * Can be called when a step is completed so this Treatment's state got updated as well
     * @param Model|ReportTreatmentStepResult $step
     * @return void
     */
    public function stepEnded(Model|ReportTreatmentStepResult $step) {

        $got_next_step = $this->setNextStep($step);

        /**  condition de Fin de Traitement:
         *      - il n'y plus d'etape a la suite
         *      - l'etape qui s'acheve est completement terminee et est succes
         */
        $complete_treatment = ( ! $got_next_step ) && ($step->isCompleted && $step->isSuccess);

        //\Log::info("stepEnded - Step:" . $step->id . ", " . $step->state->name . "/" . $step->result->name . "; complete_treatment:" . $complete_treatment);

        $this->setEnding($step->result, $step->message, $complete_treatment);
    }

    public function setNextStep(Model|ReportTreatmentStepResult $step) {
        if ( $step->isCompleted && $step->isSuccess ) {
            if ( is_null( $this->workflowstep->nextworkflowstep ) ) {
                //$this->workflowstep()->disassociate();
                return false;
            } else {
                $this->setNextWorkflowStep();
                return true;
            }
        } else {
            return false;
        }
    }

    public function setNextWorkflowStep() {
        $this->workflowstep()->associate( $this->workflowstep->nextworkflowstep )->save();
    }

    public static function setReportTreatmentQueued(int $treatmentId) {
        ReportTreatmentResult::where('id', $treatmentId)
            ->update([
                'state' => TreatmentStateEnum::QUEUED->value,
            ]);
    }

    #endregion

    /**
     * @param $reporttreatmentresultId
     * @return ReportTreatmentResult|null
     */
    public static function getById($reporttreatmentresultId) {
        return ReportTreatmentResult::find($reporttreatmentresultId);
    }

    /**
     * @return \Illuminate\Database\Query\Builder|ReportTreatmentResult[]
     */
    public static function getNotCompleted() {
        return self::notCompleted();
    }
}
