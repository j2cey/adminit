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
 *
 * @property string $description
 *
 * @property int $report_treatment_result_id
 *
 * @property int $retry_no
 * @property int $retry_session_count
 * @property int $retryof_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property ReportTreatmentResult|null $reporttreatmentresult
 * @property ReportTreatmentStepResult $retryof
 * @property ReportTreatmentStepResult[] $retries
 * @property OperationResult[] $operationresults
 * @property OperationResult $latestOperationresult
 *
 * @method static ReportTreatmentStepResult create(string[] $array)
 * @property boolean $isSuccess
 * @property boolean $isFailed
 */
class ReportTreatmentStepResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

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

    public function getIsSuccessAttribute() {
        return ($this->result == TreatmentResultEnum::SUCCESS);
    }
    public function getIsFailedAttribute() {
        return ($this->result == TreatmentResultEnum::FAILED);
    }

    #endregion

    #region Scopes

    public function scopeWaiting($query) {
        return $query
            ->where('state', TreatmentStateEnum::WAITING->value);
    }

    public function scopeNotRunning($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::RUNNING->value]);
    }

    public function scopeCompleted($query) {
        return $query
            ->where('state', TreatmentStateEnum::COMPLETED->value);
    }

    public function scopeNotCompleted($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function scopeNotAlltried($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::ALLTRIED->value]);
    }

    public function scopeFailed($query) {
        return $query
            ->where('result', TreatmentResultEnum::FAILED->value);
    }

    #endregion

    #region Eloquent Relationships
    public function reporttreatmentresult() {
        return $this->belongsTo(ReportTreatmentResult::class, "report_treatment_result_id");
    }
    public function retryof() {
        return $this->belongsTo(ReportTreatmentStepResult::class, "retryof_id");
    }
    public function retries() {
        return $this->hasMany(ReportTreatmentStepResult::class, "retryof_id");
    }
    public function operationresults() {
        return $this->hasMany(OperationResult::class, "report_treatment_step_result_id");
    }
    public function latestOperationresult()
    {
        return $this->hasOne(OperationResult::class)->latestOfMany();
    }

    public function hasreporttreatmentstepresults()
    {
        return $this->morphTo();
    }
    #endregion

    #region Custom Functions

    public static function createNew(
        TreatmentStepCode $code,
        string $name = null, Model|ReportTreatmentResult $reporttreatmentresult = null,
        Carbon $start_at = null, Carbon $end_at = null,
        TreatmentStateEnum $state = null, TreatmentResultEnum $result = null, CriticalityLevelEnum $criticality_level = null, string $message = null, string $description = null,
        ReportTreatmentStepResult $retryof = null, int $retry_no = null, int $retry_session_count = null): ReportTreatmentStepResult
    {
        $reporttreatmentstepresult = ReportTreatmentStepResult::create([
            'code' => $code->value,
            'name' => $name,
            'start_at' => $start_at ?? Carbon::now(),
            'end_at' => $end_at,
            'state' => $state ? $state->value : TreatmentStateEnum::WAITING->value,
            'result' => $result ? $result->value : TreatmentResultEnum::NONE->value,
            'criticality_level' => $criticality_level ?? CriticalityLevelEnum::MEDIUM->value,
            'message' => $message,
            'description' => $description,
            'retry_no' => $retry_no ?? 0,
            'retry_session_count' => $retry_session_count,
        ]);

        if ( ! is_null($reporttreatmentresult) ) $reporttreatmentstepresult->reporttreatmentresult()->associate($reporttreatmentresult);
        if ( ! is_null($retryof) ) $reporttreatmentstepresult->retryof()->associate($retryof);

        $reporttreatmentstepresult->save();

        return $reporttreatmentstepresult;
    }

    public function updateThis(
        TreatmentStepCode $code,
        string $name = null, Model|ReportTreatmentResult $reporttreatmentresult = null,
        Carbon $start_at = null, Carbon $end_at = null,
        string $state = null, string $result = null, string $criticality_level = null,
        string $message = null, string $description = null,
        ReportTreatmentStepResult $retryof = null, int $retry_no = null, int $retry_session_count = null): ReportTreatmentStepResult
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

        $this->retry_no = $retry_no;
        $this->retry_session_count = $retry_session_count;

        if ( ! is_null($reporttreatmentresult) ) $this->reporttreatmentresult()->associate($reporttreatmentresult);
        if ( ! is_null($retryof) ) $this->retryof()->associate($retryof);

        $this->save();

        return $this;
    }

    public function addRetry(TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, $retry_session_count = null): ReportTreatmentStepResult
    {
        $retry_no = $this->retries()->count() + 1;
        $this->retry_session_count = is_null($retry_session_count) ? (is_null($this->retry_session_count) ? 0 : $this->retry_session_count) : $retry_session_count;
        $this->save();

        return self::createNew(
            $code,
            $name,
            null,
            Carbon::now(),
            null,
            null,
            null,
            $criticality_level,
            null,
            null,
            $this,
            $retry_no,
            0
        );
    }

    public function addOperationResult($operation_name, CriticalityLevelEnum $criticalitylevelenum): OperationResult {
        $operation_no = $this->operationresults()->count() + 1;
        return OperationResult::createNew($operation_name,$operation_no,$this,null,null,null,null,null, $criticalitylevelenum);
    }

    /*public function setResultFailed() {
        $this->result = TreatmentResultEnum::FAILED;
        $this->end_at = Carbon::now();
        $this->save();
    }

    public function setResultSuccess() {
        $this->result = TreatmentResultEnum::SUCCESS;
        $this->end_at = Carbon::now();
        $this->save();
    }*/

    public function startTreatment() {
        $this->start_at = Carbon::now();
        $this->state = TreatmentStateEnum::RUNNING;

        $this->save();

        $this->setTreatmentResultStart();
    }

    public function endTreatmentWithSuccess(string $message = null) {
        $this->end_at = Carbon::now();
        $this->state = TreatmentStateEnum::COMPLETED;
        $this->result = TreatmentResultEnum::SUCCESS;

        if ( ! is_null($message) ) {
            $this->message = $message;
        }

        $this->save();

        $this->updateRetryOf();
        $this->setTreatmentResultEnd($this);
    }

    public function updateRetryOf() {
        if ( ! is_null($this->retryof) ) {

            $max_retries = config('Settings.reporttreatment.max_retries');

            if ( $this->isSuccess ) {
                $this->retryof->endTreatmentWithSuccess();
            } else {
                $this->retryof->endTreatmentWithFailure();
            }

            if ( $this->retryof->retry_session_count >= $max_retries ) {
                $this->retryof->try_end_at = Carbon::now();
                $this->retryof->state = TreatmentStateEnum::ALLTRIED;
            } else {
                $this->retryof->retry_session_count += 1;
            }

            $this->retryof->save();
        }
    }

    public function endTreatmentWithFailure(string $message = null) {
        $this->end_at = Carbon::now();
        $this->result = TreatmentResultEnum::FAILED;

        if ( ! is_null($message) ) {
            $this->message = $message;
        }

        $this->state = TreatmentStateEnum::COMPLETED;

        $this->save();

        $this->updateRetryOf();
        $this->setTreatmentResultEnd($this);
    }

    public function setTreatmentResultEnd(Model|ReportTreatmentStepResult $step) {
        if ( ! is_null($this->retryof) ) {
            $this->retryof->setTreatmentResultEnd($step);
        } else {
            if ( ! is_null($this->reporttreatmentresult) ) {
                $this->reporttreatmentresult->stepComplted($step);
            }
        }
    }

    public function setTreatmentResultStart() {
        if ( ! is_null($this->retryof) ) {
            $this->retryof->setTreatmentResultStart();
        } else {
            if ( ! is_null($this->reporttreatmentresult) ) {
                $this->reporttreatmentresult->setRunning();
            }
        }
    }

    #endregion
}
