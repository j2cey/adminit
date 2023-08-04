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
use App\Traits\ReportTreatment\IsReportTreatment;
use App\Contracts\ReportTreatment\IIsReportTreatment;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportTreatmentStep
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
 * @property Carbon $try_end_at
 * @property string|TreatmentResultEnum $result
 * @property string|TreatmentStateEnum $state
 * @property string|TreatmentStepCode $code
 * @property string|CriticalityLevelEnum $criticality_level
 * @property string $message
 * @property int $attempts
 *
 * @property string $description
 *
 * @property int $report_treatment_id
 *
 * @property string|null $hasreporttreatmentsteps_type
 * @property int|null $hasreporttreatmentsteps_id
 *
 * @property Carbon $retry_start_at
 * @property int $retries_session_count
 * @property Carbon $retry_end_at
 *
 * @property string $payload
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property ReportTreatment|null $reporttreatment
 * @property TreatmentOperation[] $treatmentoperations
 * @property TreatmentOperation $latestOperation
 * @property TreatmentOperation $lastoperation
 * @property TreatmentOperation $currentoperation
 *
 * @method static ReportTreatmentStep create(string[] $array)
 *
 * @property ReportTreatmentStep $latestRetry
 * @property ReportTreatmentStep $lastRetry
 */
class ReportTreatmentStep extends BaseModel implements Auditable, IIsReportTreatment
{
    use HasFactory, IsReportTreatment, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['treatmentoperations'];

    protected $casts = [
        'result' => TreatmentResultEnum::class,
        'state' => TreatmentStateEnum::class,
        'criticality_level' => CriticalityLevelEnum::class,
        'code' => TreatmentStepCode::class,
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

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships
    public function reporttreatment() {
        return $this->belongsTo(ReportTreatment::class, "report_treatment_id");
    }
    public function treatmentoperations() {
        return $this->hasMany(TreatmentOperation::class, "report_treatment_step_id");
    }
    public function latestOperation()
    {
        return $this->hasOne(TreatmentOperation::class, "report_treatment_step_id")->latestOfMany();
    }
    public function lastoperation() {
        return $this->belongsTo(TreatmentOperation::class, "last_operation_id");
    }
    public function currentoperation() {
        return $this->belongsTo(TreatmentOperation::class, "current_operation_id");
    }
    public function runningoperations() {
        return $this->treatmentoperations()->running();
    }

    public function hasreporttreatmentsteps()
    {
        return $this->morphTo();
    }
    #endregion

    #region Custom Functions

    /**
     * Create new ReportTreatmentStep object
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param Model|ReportTreatment|null $reporttreatment
     * @param CriticalityLevelEnum|null $criticality_level
     * @param string|null $message
     * @param string|null $description
     * @param int|null $retries_session_count
     * @return ReportTreatmentStep
     */
    public static function createNew(
        TreatmentStepCode $code,
        string $name = null, Model|ReportTreatment $reporttreatment = null,
        CriticalityLevelEnum $criticality_level = null, string $message = null, string $description = null,
        int $retries_session_count = null): ReportTreatmentStep
    {
        $reporttreatmentstep = ReportTreatmentStep::create([
            'code' => $code->value,
            'name' => $name,
            'state' => TreatmentStateEnum::WAITING->value,
            'result' => TreatmentResultEnum::NONE->value,
            'criticality_level' => $criticality_level ?? CriticalityLevelEnum::MEDIUM->value,
            'message' => $message,
            'description' => $description,
            'retries_session_count' => $retries_session_count,
        ]);

        if ( ! is_null($reporttreatment) ) $reporttreatmentstep->reporttreatment()->associate($reporttreatment);

        $reporttreatmentstep->save();

        return $reporttreatmentstep;
    }

    /**
     * Update this ReportTreatmentStep object
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param Model|ReportTreatment|null $reporttreatment
     * @param Carbon|null $start_at
     * @param Carbon|null $end_at
     * @param string|null $state
     * @param string|null $result
     * @param string|null $criticality_level
     * @param string|null $message
     * @param string|null $description
     * @param int|null $retries_session_count
     * @return $this
     */
    public function updateThis(
        TreatmentStepCode $code,
        string $name = null, Model|ReportTreatment $reporttreatment = null,
        Carbon $start_at = null, Carbon $end_at = null,
        string $state = null, string $result = null, string $criticality_level = null,
        string $message = null, string $description = null,
        int $retries_session_count = null): ReportTreatmentStep
    {
        $this->code = $code;
        $this->name = $name;
        $this->start_at = $start_at ?? Carbon::now();
        $this->end_at = $end_at ?? Carbon::now();
        $this->state = $state ?? TreatmentStateEnum::WAITING->value;
        $this->result = $result ?? TreatmentResultEnum::NONE->value;
        $this->criticality_level = $criticality_level ?? CriticalityLevelEnum::MEDIUM->value;
        $this->message = $message;
        $this->description = $description;

        $this->retries_session_count = $retries_session_count;

        if ( ! is_null($reporttreatment) ) $this->reporttreatment()->associate($reporttreatment);

        $this->save();

        return $this;
    }

    /**
     * Add an TreatmentOperation object to this ReportTreatmentStep object
     * @param $operation_name
     * @param CriticalityLevelEnum $criticalitylevel
     * @param bool $is_last_operation
     * @return TreatmentOperation
     */
    public function addTreatmentOperation($operation_name, CriticalityLevelEnum $criticalitylevel, bool $is_last_operation = false, bool $is_current_operation = false): TreatmentOperation {
        $operation_no = $this->treatmentoperations()->count() + 1;
        $treatmentoperation = TreatmentOperation::createNew($operation_name, $operation_no, $this, $criticalitylevel);
        if ($is_last_operation) {
            $this->setLastOperation($treatmentoperation);
        }
        if ($is_current_operation) {
            $this->setCurrentOperation($treatmentoperation);
        }

        return $treatmentoperation;
    }

    /**
     * Start the treatment of this ReportTreatmentStep object
     * @return $this
     */
    public function startTreatmentStep() {

        $this->setStarting(true);
        $this->setRunningOrRetrying(true);

        $this->setTreatmentStarted($this);

        return $this;
    }

    /**
     * End the treatment of this ReportTreatmentStep object
     * @param TreatmentResultEnum $result
     * @param string|null $message
     * @param bool $complete_treatment
     * @return void
     */
    public function endTreatmentStep(TreatmentResultEnum $result, string $message = null, bool $complete_treatment = false) {

        $this->setEnding($result, $message, $complete_treatment);

        /** Notification de Fin de Traitement au Traitement Principal:
         *      - cette etape est terminee
         *      - cette est etape est en echec
         */
        if ($complete_treatment || $this->isFailed) {
            $this->setTreatmentEnded($this);
        }
    }

    /**
     * End this ReportTreatmentStep object with success
     * @param string|null $message
     * @param bool $complete_treatment
     * @return void
     */
    public function endTreatmentWithSuccess(string $message = null, bool $complete_treatment = true) {
        $this->endTreatmentStep(TreatmentResultEnum::SUCCESS, $message, $complete_treatment);
    }

    /**
     * End this ReportTreatmentStep object with failure
     * @param string|null $message
     * @param bool $complete_treatment
     * @return void
     */
    public function endTreatmentWithFailure(string $message = null, bool $complete_treatment = true) {
        $this->endTreatmentStep(TreatmentResultEnum::FAILED, $message, $complete_treatment);
    }

    #region interact with (the parent) ReportTreatment object

    /**
     * Set TreatmentResult (parent) started
     * @return void
     */
    public function setTreatmentStarted(Model|ReportTreatmentStep $step) {
        if ( ! is_null($this->reporttreatment) ) {
            $this->reporttreatment->stepStarted($step);
        }
    }

    /**
     * Set TreatmentResult (parent) ended
     * @param Model|ReportTreatmentStep $step
     * @return void
     */
    public function setTreatmentEnded(Model|ReportTreatmentStep $step) {
        if ( ! is_null($this->reporttreatment) ) {
            $this->reporttreatment->stepEnded($step);
        }
    }

    #endregion


    #region interact with (step's oprations) TreatmentOperation objects

    public function setLastOperation(Model|TreatmentOperation $operation) {
        $this->lastoperation()->associate($operation)->save();
    }

    public function setCurrentOperation(Model|TreatmentOperation $operation) {
        $this->currentoperation()->associate($operation)->save();
    }

    /**
     * Can be called when an operation is started so this Step Treatment's state got updated as well
     * @param Model|TreatmentOperation $operation
     * @return void
     */
    public function operationStarted(Model|TreatmentOperation $operation) {
        $this->startTreatmentStep();
    }

    /**
     * Can be called when an operation is completed so this Step Treatment's state got updated as well
     * @param Model|TreatmentOperation $operation
     * @return void
     */
    public function operationCompleted(Model|TreatmentOperation $operation) {

        /**  condition de Fin de Traitement:
         *      - l'etape qui s'acheve n'est pas un echec
         *      - l'etape qui s'acheve est la derniere et est un succes
         */
        $complete_treatment = !$operation->isFailed && $operation->isLastOperation && $operation->isSuccess;

        //\Log::info("operationCompleted - Step:".$this->id."; operation:".$operation->id.", ".$operation->state->name."/".$operation->result->name." is last:".$operation->isLastOperation);

        $this->endTreatmentStep($operation->result,$operation->message, $complete_treatment);
    }

    public function setAsCurrentStep() {
        $this->reporttreatment->setCurrentStep($this);
    }

    /**
     * @return TreatmentOperation|null
     */
    public function getFirstOperationWaiting() {
        return $this->treatmentoperations()->waiting()->first();
    }

    #endregion

    #endregion
}
