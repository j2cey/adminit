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
use App\Traits\ReportTreatment\IsReportTreatment;
use App\Contracts\ReportTreatment\IIsReportTreatment;

/**
 * Class TreatmentOperation
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
 * @property TreatmentResultEnum $result
 * @property TreatmentStateEnum $state
 * @property string|TreatmentStepCode $code
 * @property string $criticality_level
 * @property string $message
 * @property int $attempts
 *
 * @property string $description
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
 * @property int|null $report_treatment_step_id
 * @property int|null $parent_operation_id
 *
 * @property ReportTreatmentStep|null $reporttreatmentstep
 * @property TreatmentOperation|null $parentoperation
 * @property TreatmentOperation[]|null $childrenoperations
 * @method static TreatmentOperation create(string[] $array)
 * @property boolean $isLastOperation
 */
class TreatmentOperation extends BaseModel implements Auditable, IIsReportTreatment
{
    use HasFactory, IsReportTreatment, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
        'result' => TreatmentResultEnum::class,
        'state' => TreatmentStateEnum::class,
        'criticality_level' => CriticalityLevelEnum::class,
        'code' => TreatmentStepCode::class,
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

    public function getIsLastOperationAttribute() {
        if ( is_null( $this->reporttreatmentstep->lastoperation )) {
            return false;
        } else {
            return $this->reporttreatmentstep->lastoperation->id === $this->id;
        }
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships
    public function reporttreatmentstep() {
        return $this->belongsTo(ReportTreatmentStep::class, "report_treatment_step_id");
    }
    public function parentoperation() {
        return $this->belongsTo(TreatmentOperation::class, "parent_operation_id");
    }
    public function childrenoperations() {
        return $this->hasMany(TreatmentOperation::class, "parent_operation_id");
    }
    public function lastoperation() {
        return $this->belongsTo(TreatmentOperation::class, "last_operation_id");
    }
    #endregion

    #region Custom Functions

    /**
     * Create a new TreatmentOperation Object
     * @param string $name
     * @param int|null $operation_no
     * @param Model|ReportTreatmentStep|null $reporttreatmentstep
     * @param CriticalityLevelEnum|null $criticality_level
     * @param string|null $message
     * @param string|null $description
     * @param Model|TreatmentOperation|null $parentoperation
     * @return TreatmentOperation
     */
    public static function createNew(
        string $name,
        int $operation_no = null,
        Model|ReportTreatmentStep $reporttreatmentstep = null,
        CriticalityLevelEnum $criticality_level = null,
        string $message = null, string $description = null, Model|TreatmentOperation $parentoperation = null): TreatmentOperation
    {
        $treatmentoperation = TreatmentOperation::create([
            'name' => $name,
            'operation_no' => $operation_no ?? 0,
            'state' => TreatmentStateEnum::WAITING->value,
            'result' => TreatmentResultEnum::NONE->value,
            'criticality_level' => $criticality_level ? $criticality_level->value : CriticalityLevelEnum::MEDIUM->value,
            'message' => $message,
            'description' => $description,
        ]);

        $treatmentoperation->setReportTreatmentStep($reporttreatmentstep);
        $treatmentoperation->setParent($parentoperation);

        $treatmentoperation->save();

        return $treatmentoperation;
    }

    /**
     * Update this TreatmentOperation Object
     * @param string $name
     * @param int|null $operation_no
     * @param Model|ReportTreatmentStep|null $reporttreatmentstep
     * @param Carbon|null $start_at
     * @param Carbon|null $end_at
     * @param int|null $operation_duration
     * @param TreatmentStateEnum|null $state
     * @param TreatmentResultEnum|null $result
     * @param CriticalityLevelEnum|null $criticality_level
     * @param string|null $message
     * @param string|null $description
     * @param Model|TreatmentOperation|null $parentoperation
     * @return $this
     */
    public function updateThis(
        string $name,
        int $operation_no = null,
        Model|ReportTreatmentStep $reporttreatmentstep = null,
        Carbon $start_at = null, Carbon $end_at = null, int $operation_duration = null,
        TreatmentStateEnum $state = null, TreatmentResultEnum $result = null, CriticalityLevelEnum $criticality_level = null,
        string $message = null, string $description = null, Model|TreatmentOperation $parentoperation = null): TreatmentOperation
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

        $this->setReportTreatmentStep($reporttreatmentstep);
        $this->setParent($parentoperation);

        $this->save();

        return $this;
    }

    /**
     * Start the treatment of this TreatmentOperation object
     * @return $this
     */
    public function startOperation(): TreatmentOperation
    {
        $this->setStarting(true);
        $this->setRunning(true);

        if ( is_null($this->parentoperation) ) {
            $this->reporttreatmentstep->operationStarted($this);
        } else {
            $this->parentoperation->childOperationStarted($this);
        }

        return $this;
    }

    /**
     * End the treatment of this TreatmentOperation object
     * @param TreatmentResultEnum $treatmentresultenum
     * @param string $message
     * @param bool $complete_treatment
     * @return void
     */
    public function endOperation(TreatmentResultEnum $treatmentresultenum, string $message, bool $complete_treatment) {
        $this->setEnding($treatmentresultenum, $message, $complete_treatment);

        if ( is_null($this->parentoperation) ) {
            $this->reporttreatmentstep->operationCompleted($this);
        } else {
            $this->parentoperation->childOperationCompleted($this);
        }
    }

    /**
     * End the treatment of this TreatmentOperation object with success
     * @param string|null $message
     * @return $this
     */
    public function endWithSuccess(string $message = null, bool $complete_treatment = true): TreatmentOperation
    {
        $this->endOperation(TreatmentResultEnum::SUCCESS, $message ?? "Success", $complete_treatment);

        return $this;
    }

    /**
     * End the treatment of this TreatmentOperation object with failure
     * @param string|null $message
     * @return $this
     */
    public function endWithFailure(string $message = null): TreatmentOperation
    {
        $this->endOperation(TreatmentResultEnum::FAILED, $message ?? "Failed", true);

        return $this;
    }

    public function childOperationStarted(Model|TreatmentOperation $childoperation) {
        if ( ! $this->isRunning ) {
            $this->startOperation();
        }
    }

    public function childOperationCompleted(Model|TreatmentOperation $childoperation) {
        /**  condition de Fin de l'operation:
         *      - l'operation enfant qui s'acheve n'est pas un echec
         *      - l'operation enfant qui s'acheve est la derniere et est un succes
         */
        $complete_treatment = !$childoperation->isFailed && $childoperation->isLastOperation && $childoperation->isSuccess;
        $this->endOperation($childoperation->result,$childoperation->message, $complete_treatment);
    }

    public function setAsLastOperation() {
        if ( is_null($this->parentoperation) ) {
            $this->reporttreatmentstep->setLastOperation($this);
        } else {
            $this->parentoperation->setLastOperation($this);
        }
    }

    /**
     * @return TreatmentOperation
     */
    public function setAsCurrentOperation() {
        $this->reporttreatmentstep->setCurrentOperation($this);
        return $this;
    }

    /**
     * @param CriticalityLevelEnum $criticalitylevel
     * @return TreatmentOperation
     */
    public function setCriticalityLevel(CriticalityLevelEnum $criticalitylevel): TreatmentOperation
    {
        $this->criticality_level = $criticalitylevel->value;
        $this->save();

        return $this;
    }

    /**
     * @return TreatmentOperation
     */
    public function setCode(TreatmentStepCode $code) {
        $this->code = $code;
        $this->save();

        return $this;
    }

    public function setReportTreatmentStep(Model|ReportTreatmentStep $reporttreatmentstep = null) {
        if ( ! is_null($reporttreatmentstep) ) $this->reporttreatmentstep()->associate($reporttreatmentstep);
    }
    public function setParent(Model|TreatmentOperation $childoperation = null) {
        $operation_no = $this->childrenoperations()->count() + 1;
        if ( ! is_null($childoperation) ) {
            $this->parentoperation()->associate($childoperation)->save();
            $childoperation->update([
                'operation_no' => $operation_no
            ]);
        }
    }
    public function addChildOperation(string $name, CriticalityLevelEnum $criticality_level = null) {
        $childoperation = TreatmentOperation::createNew($name,null,null,$criticality_level);
        $childoperation->setParent($childoperation);
        return $childoperation;
    }

    /**
     * @return TreatmentOperation|null
     */
    public function getNextChildOperationWaiting() {
        if ( $this->childrenoperations()->waiting()->notFailed()->count() >= $this->childrenoperations()->count() ) {
            return null;
        }
        $nextchildoperation = $this->childrenoperations()
            ->waiting()->notFailed()
            ->orderBy('operation_no', 'ACS')->first();

        return $nextchildoperation;
    }

    public function setLastOperation(Model|TreatmentOperation $operation) {
        $this->lastoperation()->associate($operation)->save();
    }

    #endregion
}
