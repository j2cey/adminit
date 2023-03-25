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
 * @property int $operation_no
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property int $operation_duration
 * @property string $state
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
 * @method static OperationResult create(string[] $array)
 */
class OperationResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
        'state' => TreatmentStateEnum::class,
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
        string $state = null, string $message = null, string $description = null, Model|OperationResult $parentoperation = null): OperationResult
    {
        $operationresult = OperationResult::create([
            'name' => $name,
            'operation_no' => $operation_no,
            'start_at' => $start_at ?? Carbon::now(),
            'end_at' => $end_at ?? Carbon::now(),
            'operation_duration' => $operation_duration,
            'state' => $state ?? TreatmentStateEnum::WAITING->value,
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
        string $state = null, string $message = null, string $description = null, Model|OperationResult $parentoperation = null): OperationResult
    {
        $this->name = $name;
        $this->operation_no = $operation_no;
        $this->start_at = $start_at ?? Carbon::now();
        $this->end_at = $end_at ?? Carbon::now();
        $this->operation_duration = $operation_duration;
        $this->state = $state ?? TreatmentStateEnum::WAITING->value;
        $this->message = $message;
        $this->description = $description;

        $this->setReportTreatmentStepResult($reporttreatmentstepresult);
        $this->setParent($parentoperation);

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
