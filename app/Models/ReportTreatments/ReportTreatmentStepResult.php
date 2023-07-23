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
use App\Traits\ReportTreatmentResult\IsReportTreatment;
use App\Contracts\ReportTreatmentResult\IIsReportTreatment;

/**
 * Class ReportTreatmentStepResult
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
 * @property int $report_treatment_result_id
 *
 * @property string|null $hasreporttreatmentstepresults_type
 * @property int|null $hasreporttreatmentstepresults_id
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
 * @property ReportTreatmentResult|null $reporttreatmentresult
 * @property OperationResult[] $operationresults
 * @property OperationResult $latestOperationresult
 * @property OperationResult $lastoperation
 * @property OperationResult $currentoperation
 *
 * @method static ReportTreatmentStepResult create(string[] $array)
 *
 * @property ReportTreatmentStepResult $latestRetry
 * @property ReportTreatmentStepResult $lastRetry
 */
class ReportTreatmentStepResult extends BaseModel implements Auditable, IIsReportTreatment
{
    use HasFactory, IsReportTreatment, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['operationresults'];

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
    public function reporttreatmentresult() {
        return $this->belongsTo(ReportTreatmentResult::class, "report_treatment_result_id");
    }
    public function operationresults() {
        return $this->hasMany(OperationResult::class, "report_treatment_step_result_id");
    }
    public function latestOperationresult()
    {
        return $this->hasOne(OperationResult::class, "report_treatment_step_result_id")->latestOfMany();
    }
    public function lastoperation() {
        return $this->belongsTo(OperationResult::class, "last_operation_id");
    }
    public function currentoperation() {
        return $this->belongsTo(OperationResult::class, "current_operation_id");
    }
    public function runningoperations() {
        return $this->operationresults()->running();
    }

    public function hasreporttreatmentstepresults()
    {
        return $this->morphTo();
    }
    #endregion

    #region Custom Functions

    /**
     * Create new ReportTreatmentStepResult object
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param Model|ReportTreatmentResult|null $reporttreatmentresult
     * @param CriticalityLevelEnum|null $criticality_level
     * @param string|null $message
     * @param string|null $description
     * @param int|null $retries_session_count
     * @return ReportTreatmentStepResult
     */
    public static function createNew(
        TreatmentStepCode $code,
        string $name = null, Model|ReportTreatmentResult $reporttreatmentresult = null,
        CriticalityLevelEnum $criticality_level = null, string $message = null, string $description = null,
        int $retries_session_count = null): ReportTreatmentStepResult
    {
        $reporttreatmentstepresult = ReportTreatmentStepResult::create([
            'code' => $code->value,
            'name' => $name,
            'state' => TreatmentStateEnum::WAITING->value,
            'result' => TreatmentResultEnum::NONE->value,
            'criticality_level' => $criticality_level ?? CriticalityLevelEnum::MEDIUM->value,
            'message' => $message,
            'description' => $description,
            'retries_session_count' => $retries_session_count,
        ]);

        if ( ! is_null($reporttreatmentresult) ) $reporttreatmentstepresult->reporttreatmentresult()->associate($reporttreatmentresult);

        $reporttreatmentstepresult->save();

        return $reporttreatmentstepresult;
    }

    /**
     * Update this ReportTreatmentStepResult object
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param Model|ReportTreatmentResult|null $reporttreatmentresult
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
        string $name = null, Model|ReportTreatmentResult $reporttreatmentresult = null,
        Carbon $start_at = null, Carbon $end_at = null,
        string $state = null, string $result = null, string $criticality_level = null,
        string $message = null, string $description = null,
        int $retries_session_count = null): ReportTreatmentStepResult
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

        if ( ! is_null($reporttreatmentresult) ) $this->reporttreatmentresult()->associate($reporttreatmentresult);

        $this->save();

        return $this;
    }

    /**
     * Add an OperationResult object to this ReportTreatmentStepResult object
     * @param $operation_name
     * @param CriticalityLevelEnum $criticalitylevel
     * @param bool $is_last_operation
     * @return OperationResult
     */
    public function addOperationResult($operation_name, CriticalityLevelEnum $criticalitylevel, bool $is_last_operation = false, bool $is_current_operation = false): OperationResult {
        $operation_no = $this->operationresults()->count() + 1;
        $operationresult = OperationResult::createNew($operation_name, $operation_no, $this, $criticalitylevel);
        if ($is_last_operation) {
            $this->setLastOperation($operationresult);
        }
        if ($is_current_operation) {
            $this->setCurrentOperation($operationresult);
        }

        return $operationresult;
    }

    /**
     * Start the treatment of this ReportTreatmentStepResult object
     * @return $this
     */
    public function startStepTreatment() {

        $this->setStarting(true);
        $this->setRunningOrRetrying(true);

        $this->setTreatmentResultStarted($this);

        return $this;
    }

    /**
     * End the treatment of this ReportTreatmentStepResult object
     * @param TreatmentResultEnum $result
     * @param string|null $message
     * @param bool $complete_treatment
     * @return void
     */
    public function endStepTreatment(TreatmentResultEnum $result, string $message = null, bool $complete_treatment = false) {

        $this->setEnding($result, $message, $complete_treatment);

        /** Notification de Fin de Traitement au Traitement Principal:
         *      - cette etape est terminee
         *      - cette est etape est en echec
         */
        if ($complete_treatment || $this->isFailed) {
            $this->setTreatmentResultEnded($this);
        }
    }

    /**
     * End this ReportTreatmentStepResult object with success
     * @param string|null $message
     * @param bool $complete_treatment
     * @return void
     */
    public function endTreatmentWithSuccess(string $message = null, bool $complete_treatment = true) {
        $this->endStepTreatment(TreatmentResultEnum::SUCCESS, $message, $complete_treatment);
    }

    /**
     * End this ReportTreatmentStepResult object with failure
     * @param string|null $message
     * @param bool $complete_treatment
     * @return void
     */
    public function endTreatmentWithFailure(string $message = null, bool $complete_treatment = true) {
        $this->endStepTreatment(TreatmentResultEnum::FAILED, $message, $complete_treatment);
    }

    #region interact with (the parent) ReportTreatmentResult object

    /**
     * Set TreatmentResult (parent) started
     * @return void
     */
    public function setTreatmentResultStarted(Model|ReportTreatmentStepResult $step) {
        if ( ! is_null($this->reporttreatmentresult) ) {
            $this->reporttreatmentresult->stepStarted($step);
        }
    }

    /**
     * Set TreatmentResult (parent) ended
     * @param Model|ReportTreatmentStepResult $step
     * @return void
     */
    public function setTreatmentResultEnded(Model|ReportTreatmentStepResult $step) {
        if ( ! is_null($this->reporttreatmentresult) ) {
            $this->reporttreatmentresult->stepEnded($step);
        }
    }

    #endregion


    #region interact with (step's oprations) OperationResult objects

    public function setLastOperation(Model|OperationResult $operation) {
        $this->lastoperation()->associate($operation)->save();
    }

    public function setCurrentOperation(Model|OperationResult $operation) {
        $this->currentoperation()->associate($operation)->save();
    }

    /**
     * Can be called when an operation is started so this Step Treatment's state got updated as well
     * @param Model|OperationResult $operation
     * @return void
     */
    public function operationStarted(Model|OperationResult $operation) {
        $this->startStepTreatment();
    }

    /**
     * Can be called when an operation is completed so this Step Treatment's state got updated as well
     * @param Model|OperationResult $operation
     * @return void
     */
    public function operationCompleted(Model|OperationResult $operation) {

        /**  condition de Fin de Traitement:
         *      - l'etape qui s'acheve n'est pas un echec
         *      - l'etape qui s'acheve est la derniere et est un succes
         */
        $complete_treatment = !$operation->isFailed && $operation->isLastOperation && $operation->isSuccess;

        //\Log::info("operationCompleted - Step:".$this->id."; operation:".$operation->id.", ".$operation->state->name."/".$operation->result->name." is last:".$operation->isLastOperation);

        $this->endStepTreatment($operation->result,$operation->message, $complete_treatment);
    }

    public function setAsCurrentStep() {
        $this->reporttreatmentresult->setCurrentStep($this);
    }

    /**
     * @return OperationResult|null
     */
    public function getFirstOperationWaiting() {
        return $this->operationresults()->waiting()->first();
    }

    #endregion

    #endregion
}
