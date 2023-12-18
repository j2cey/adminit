<?php

namespace App\Models\ReportTreatments;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\Base\ModelPickable;
use App\Enums\CriticalityLevelEnum;
use App\Models\ReportFile\ReportFile;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentTypeEnum;
use App\Enums\Treatments\TreatmentStateEnum;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\ReportTreatment\HasReportFile;
use App\Traits\ReportTreatment\HasDynamicRow;
use App\Traits\ReportTreatment\HasDynamicValue;
use App\Contracts\ReportTreatment\ITreatmentType;
use App\Contracts\ReportTreatment\IHasReportFile;
use App\Contracts\ReportTreatment\IHasDynamicRow;
use App\Contracts\ReportTreatment\IHasDynamicValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ReportTreatment\HasCollectedReportFile;
use App\Models\ReportTreatments\Treatment\RawTreatment;
use App\Models\ReportTreatments\Treatment\MainTreatment;
use App\Models\ReportTreatments\Treatment\TreatmentEnding;
use App\Models\ReportTreatments\Treatment\StateManagement;
use App\Contracts\ReportTreatment\IHasCollectedReportFile;
use App\Models\ReportTreatments\Treatment\ResultManagement;
use App\Models\ReportTreatments\Treatment\ServiceManagement;
use App\Models\ReportTreatments\Treatment\TreatmentRawInfos;
use App\Models\ReportTreatments\Treatment\PayloadManagement;
use App\Models\ReportTreatments\Treatment\TreatmentStarting;
use App\Models\ReportTreatments\Treatment\TreatmentAttempting;

/**
 * Class Treatment
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string|TreatmentTypeEnum $type
 * @property string|ITreatmentType $treatmenttype_class
 * @property string|TreatmentCodeEnum $code
 * @property integer $level
 * @property integer $exec_id
 * @property string $exectrace
 * @property integer $num_ord
 * @property string|CriticalityLevelEnum $criticality_level
 * @property string|TreatmentStateEnum $prev_state
 * @property string|TreatmentStateEnum $state
 *
 * @property bool $is_last_subtreatment
 * @property bool $can_end_uppertreatment
 * @property bool $all_subtreatments_launched
 * @property bool $all_subtreatments_completed
 * @property bool $dispatch_on_creation
 * @property bool $launch_exec_operation_on_creation
 * @property bool $dispatch_exec_operation_on_creation
 *
 * @property string $payload
 * @property string $innertreatments
 * @property string $description
 *
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property int|null $duration
 * @property string|null $duration_hhmmss
 *
 * @property int $attempts
 * @property Carbon $retry_start_at
 * @property int $retries_session_count
 * @property Carbon $retry_end_at
 *
 * @property int|null $uppertreatment_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property boolean $isHighCritical
 *
 * @method static Builder toProcessOrProcessing()
 * @method static Treatment create(array $array)
 *
 * @property ReportFile $reportfile
 * @property Treatment $uppertreatment
 * @property Treatment $lastestsubtreatment
 * @property Treatment[] $subtreatments
 * @property Treatment[] $subtreatmentswaiting
 * @property TreatmentService $service
 * @property TreatmentResult $treatmentresult
 */
class Treatment extends  BaseModel implements Auditable, IHasReportFile, IHasCollectedReportFile, IHasDynamicRow, IHasDynamicValue
{
    // * @method static Treatment create(array|null $array)
    // * @method static Treatment|null find(int $id)
    use HasFactory, \OwenIt\Auditing\Auditable,
        TreatmentRawInfos,
        RawTreatment,
        ServiceManagement,
        ResultManagement,
        StateManagement,
        PayloadManagement,
        TreatmentAttempting,
        TreatmentStarting,
        TreatmentEnding,
        MainTreatment,
        HasReportFile,
        HasCollectedReportFile,
        HasDynamicRow,
        HasDynamicValue,
        ModelPickable;

    protected $guarded = [];

    protected $casts = [
        'type' => TreatmentTypeEnum::class,
        'code' => TreatmentCodeEnum::class,
        'criticality_level' => CriticalityLevelEnum::class,
        'state' => TreatmentStateEnum::class,
        'start_at' => 'date',
        'end_at' => 'date',
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

    public function getIsHighCriticalAttribute() {
        return $this->criticality_level == CriticalityLevelEnum::HIGH;
    }

    #region Eloquent Relationships

    public function service() {
        return $this->belongsTo(TreatmentService::class, 'treatment_service_id');
    }
    public function uppertreatment() {
        return $this->belongsTo(Treatment::class, 'uppertreatment_id');
    }
    public function subtreatments() {
        return $this->hasMany(Treatment::class, 'uppertreatment_id');
    }
    public function subtreatmentswaiting() {
        return $this->hasMany(Treatment::class, 'uppertreatment_id')->waiting();
    }
    public function lastestsubtreatment()
    {
        return $this->hasOne(Treatment::class, 'uppertreatment_id')->latest('id');
    }

    #endregion

    #region scopes

    /**
     * @param TreatmentCodeEnum $code
     * @return Treatment|Builder|Model|object|null
     */
    public static function waitingGetFirst(TreatmentCodeEnum $code) {
        return Treatment::waiting()->where('code', $code->value)->first();
    }

    /**
     * @param TreatmentCodeEnum $code
     * @return Treatment|Builder|Model|object|null
     */
    public static function notstartedOrWaitingGetFirst(TreatmentCodeEnum $code) {
        return Treatment::notstartedOrWaiting()->where('code', $code->value)->first();
    }

    /**
     * @param TreatmentCodeEnum $code
     * @return Treatment|Builder|Model|object|null
     */
    public static function notStartedGetFirst(TreatmentCodeEnum $code) {
        return Treatment::notstarted()->where('code', $code->value)->first();
    }

    /**
     * @param TreatmentCodeEnum $code
     * @return Treatment|null
     */
    public static function pickWaiting(TreatmentCodeEnum $code) {
        return Treatment::pick([['field' => "state", 'value'=> TreatmentStateEnum::WAITING], ['field' => "code", 'value'=> $code->value]]);
    }

    /**
     * @return Builder[]|Collection|Treatment[]
     */
    public static function getToDispach() {
        return Treatment::todispatch()->get();
    }

    public function scopeToProcessOrProcessing($query) {
        return $query->whereIn('state', [TreatmentStateEnum::QUEUED->value, TreatmentStateEnum::WAITING->value, TreatmentStateEnum::RUNNING->value, TreatmentStateEnum::RETRYING->value]);
    }

    public function subTreatmentsToProcessOrProcessingCount(): int {
        return $this->subtreatments() ? $this->subtreatments()->toProcessOrProcessing()->count() : 0;
    }

    #endregion

    #region Custom Functions



    #endregion
}
