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
        if ( ! is_null($retryof) ) $reporttreatmentresult->retryof()->associate($retryof);

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

    public function addRetry($retry_session_count = 0): ReportTreatmentStepResult
    {
        $retry_no = $this->retries()->count() + 1;

        return self::createNew(
            $this->code,
            null,
            null,
            Carbon::now(),
            null,
            null,
            null,
            null,
            $this,
            $retry_no,
            $retry_session_count
        );
    }

    public function addOperationResult($operation_name, CriticalityLevelEnum $criticalitylevelenum): OperationResult {
        $operation_no = $this->operationresults()->count() + 1;
        return OperationResult::createNew($operation_name,$operation_no,null,null,null,null,null,null, $criticalitylevelenum);
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
    }

    public function endTreatmentWithSuccess(string $message = null) {
        $this->end_at = Carbon::now();
        $this->state = TreatmentStateEnum::COMPLETED;
        $this->result = TreatmentResultEnum::SUCCESS;

        if ( ! is_null($message) ) {
            $this->message = $message;
        }

        $this->save();
    }

    public function endTreatmentWithFailure(string $message = null) {
        $this->end_at = Carbon::now();
        $this->state = TreatmentStateEnum::COMPLETED;
        $this->result = TreatmentResultEnum::FAILED;

        if ( ! is_null($message) ) {
            $this->message = $message;
        }

        $this->save();
    }

    #endregion
}
