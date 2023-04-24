<?php

namespace App\Models\ReportTreatments;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
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
 * @property int $operation_no
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property int $operation_duration
 * @property string $result
 * @property string $state
 * @property string $criticality_level
 * @property string $message
 *
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property int|null $report_treatment_step_result_id
 * @property int|null $parent_operation_id
 *
 * @property ReportTreatmentStepResult|null $reporttreatmentstepresult
 * @property OperationResult|null $parentoperation
 * @property boolean $isSuccess
 * @property boolean $isFailed
 * @method static OperationResult create(string[] $array)
 */
class OperationResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
        'result' => TreatmentResultEnum::class,
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required']
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
            'name.required' => "Prière de renseigner le nom de l'opération"
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
    public function reporttreatmentstepresult() {
        return $this->belongsTo(ReportTreatmentStepResult::class, "report_treatment_step_result_id");
    }
    public function parentoperation() {
        return $this->belongsTo(OperationResult::class, "parent_operation_id");
    }
    #endregion

    #region Custom Functions

    public static function createNew(
        string $name,
        int $operation_no = null,
        Model|ReportTreatmentStepResult $reporttreatmentstepresult = null,
        Carbon $start_at = null, Carbon $end_at = null, int $operation_duration = null,
        TreatmentStateEnum $state = null, TreatmentResultEnum $result = null, CriticalityLevelEnum $criticality_level = null,
        string $message = null, string $description = null, Model|OperationResult $parentoperation = null): OperationResult
    {
        $operationresult = OperationResult::create([
            'name' => $name,
            'operation_no' => $operation_no,
            'start_at' => $start_at ?? Carbon::now(),
            'end_at' => $end_at ?? Carbon::now(),
            'operation_duration' => $operation_duration,
            'state' => $state ? $state->value : TreatmentStateEnum::WAITING->value,
            'result' => $result ? $result->value : TreatmentResultEnum::NONE->value,
            'criticality_level' => $criticality_level ? $criticality_level->value : CriticalityLevelEnum::MEDIUM->value,
            'message' => $message,
            'description' => $description,
        ]);

        $operationresult->setReportTreatmentStepResult($reporttreatmentstepresult);
        $operationresult->setParent($parentoperation);

        $operationresult->save();

        return $operationresult;
    }

    public function updateThis(
        string $name,
        int $operation_no = null,
        Model|ReportTreatmentStepResult $reporttreatmentstepresult = null,
        Carbon $start_at = null, Carbon $end_at = null, int $operation_duration = null,
        TreatmentStateEnum $state = null, TreatmentResultEnum $result = null, CriticalityLevelEnum $criticality_level = null,
        string $message = null, string $description = null, Model|OperationResult $parentoperation = null): OperationResult
    {
        $this->name = $name;
        $this->operation_no = $operation_no;
        $this->start_at = $start_at ?? Carbon::now();
        $this->end_at = $end_at ?? Carbon::now();
        $this->operation_duration = $operation_duration;
        $this->state = $state ? $state->value : TreatmentStateEnum::WAITING->value;
        $this->result = $result ? $result->value : TreatmentResultEnum::NONE->value;
        $this->criticality_level = $criticality_level ? $criticality_level->value : CriticalityLevelEnum::MEDIUM->value;
        $this->message = $message;
        $this->description = $description;

        $this->setReportTreatmentStepResult($reporttreatmentstepresult);
        $this->setParent($parentoperation);

        $this->save();

        return $this;
    }

    public function endWithSuccess(string $message = null): OperationResult
    {
        $this->state = TreatmentStateEnum::COMPLETED->value;
        $this->result = TreatmentResultEnum::SUCCESS->value;
        $this->message = $message ?? "Success";
        $this->end_at = Carbon::now();
        $this->save();

        return $this;
    }

    public function endWithFailure(string $message = null): OperationResult
    {
        $this->state = TreatmentStateEnum::COMPLETED->value;
        $this->result = TreatmentResultEnum::FAILED->value;
        $this->message = $message ?? "Failed";
        $this->end_at = Carbon::now();
        $this->save();

        return $this;
    }

    public function setCriticalityLevel(CriticalityLevelEnum $criticalitylevel): OperationResult
    {
        $this->criticality_level = $criticalitylevel->value;
        $this->save();

        return $this;
    }

    public function setReportTreatmentStepResult(Model|ReportTreatmentStepResult|null $reporttreatmentstepresult) {
        if ( ! is_null($reporttreatmentstepresult) ) $this->reporttreatmentstepresult()->associate($reporttreatmentstepresult);
    }
    public function setParent(Model|OperationResult|null $parentoperation) {
        if ( ! is_null($parentoperation) ) $this->parentoperation()->associate($parentoperation);
    }

    #endregion
}
