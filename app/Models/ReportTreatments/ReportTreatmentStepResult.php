<?php

namespace App\Models\ReportTreatments;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Enums\TreatmentStateEnum;
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
 * @property string $state
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
 *
 * @method static ReportTreatmentStepResult create(string[] $array)
 */
class ReportTreatmentStepResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
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
    #endregion

    #region Custom Functions

    public static function createNew(string $name = null, Model|ReportTreatmentResult $reporttreatmentresult = null, Carbon $start_at = null, Carbon $end_at = null, string $state = null, string $message = null, string $description = null, ReportTreatmentStepResult $retryof = null, int $retry_no = null, int $retry_session_count = null): ReportTreatmentStepResult
    {
        $reporttreatmentstepresult = ReportTreatmentStepResult::create([
            'name' => $name,
            'start_at' => $start_at ?? Carbon::now(),
            'end_at' => $end_at ?? Carbon::now(),
            'state' => $state ?? TreatmentStateEnum::WAITING->value,
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

    public function updateThis(string $name = null, Model|ReportTreatmentResult $reporttreatmentresult = null, Carbon $start_at = null, Carbon $end_at = null, string $state = null, string $message = null, string $description = null, ReportTreatmentStepResult $retryof = null, int $retry_no = null, int $retry_session_count = null): ReportTreatmentStepResult
    {
        $this->name = $name;
        $this->start_at = $start_at ?? Carbon::now();
        $this->end_at = $end_at ?? Carbon::now();
        $this->state = $state ?? TreatmentStateEnum::WAITING->value;
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
            null,
            null,
            Carbon::now(),
            null,
            TreatmentStateEnum::WAITING->value,
            null,
            null,
            $this,
            $retry_no,
            $retry_session_count
        );
    }

    public function addOperationResult($operation_name): OperationResult {
        $operation_no = $this->operationresults()->count() + 1;
        return OperationResult::createNew($operation_name,$operation_no);
    }

    #endregion
}
