<?php

namespace App\Models\Treatments;

use App\Models\Status;
use App\Enums\QueueEnum;
use App\Models\BaseModel;
use App\Models\SystemLog;
use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
use App\Models\DynamicValue\DynamicRow;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\DynamicValue\DynamicValue;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Traits\ReportTreatment\HasReportFile;
use App\Traits\ReportTreatment\HasDynamicRow;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\ReportTreatment\HasDynamicValue;
use App\Contracts\ReportTreatment\IHasReportFile;
use App\Contracts\ReportTreatment\IHasDynamicRow;
use App\Contracts\ReportTreatment\IServiceActions;
use App\Contracts\ReportTreatment\IHasDynamicValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ReportTreatment\HasCollectedReportFile;
use App\Contracts\ReportTreatment\IHasCollectedReportFile;
use App\Models\Treatments\TreatmentService\ServiceActions;

/**
 * Class TreatmentService
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property int|null $exec_id
 * @property string|QueueEnum $queue_code
 * @property string|IServiceActions $serviceactions_class
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static TreatmentService create(array $array)
 * @method static TreatmentService find(int $id)
 *
 * @property Treatment $treatment
 */
class TreatmentService extends BaseModel implements Auditable, IHasReportFile, IHasCollectedReportFile, IHasDynamicRow, IHasDynamicValue
{
    use HasFactory,
        \OwenIt\Auditing\Auditable,
        ServiceActions,
        HasReportFile,
        HasCollectedReportFile,
        HasDynamicRow,
        HasDynamicValue;

    public static string $TREATMENTSERVICE_LOG_INFO_PART = "treatmentservice";
    public ?IServiceActions $service_object = null;

    protected $guarded = [];
    //protected $with = [];

    protected $casts = [
        'queue_code' => QueueEnum::class,
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

    #region Scopes

    #endregion

    #region Eloquent Relationships

    public function treatment()
    {
        return $this->hasOne(Treatment::class, 'treatment_service_id');
    }

    /**
     * @return IServiceActions
     */
    public function getServiceObject(): IServiceActions
    {
        if ( is_null($this->service_object) ) {
            $this->service_object = new $this->serviceactions_class($this->treatment);
        }
        return $this->service_object;
    }

    #endregion

    #region Custom Functions

    public static function getById(int $id): ?TreatmentService {
        return TreatmentService::find($id);
    }

    public static function createNew(Treatment $treatment, string|TreatmentCodeEnum $code, string|null $description): Model|TreatmentService|null
    {
        try {
            $service = TreatmentService::create([
                'description' => $description,
                'serviceactions_class' => $code->toFullArray()['serviceclass'],
            ]);

            $treatment->service()->associate($service)->save();

            return $service;
        } catch (\Throwable $e) {
            SystemLog::errorTreatments( "Error Create TreatmentService for " . $treatment->name . " (" . $treatment->id  . ") \n Message: " . $e->getMessage()  . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() . "; \n" . "Trace: " . $e->getTraceAsString()  , self::$TREATMENTSERVICE_LOG_INFO_PART );
            return null;
        }
    }

    public function updateThis(string|QueueEnum $queue_code = null, string $description = null, Status $status = null, ReportFile $reportFile = null, CollectedReportFile $collectedreportfile = null, DynamicRow $dynamicrow = null, DynamicValue $dynamicvalue = null): TreatmentService
    {
        $this->description = $description;

        if ( ! is_null($status) ) $this->status()->associate($status);

        $this->save();

        $this
            ->setQueueCode($queue_code)
            ->setReportFile($reportFile)
            ->setCollectedReportFile($collectedreportfile)
            ->setDynamicRow($dynamicrow)
            ->setDynamicValue($dynamicvalue);

        return $this;
    }

    /*public function initExec(string $description = null, ReportFile $reportFile = null, CollectedReportFile $collectedreportfile = null, DynamicRow $dynamicrow = null, DynamicValue $dynamicvalue = null): TreatmentService {

        $this->description = $description;

        $this->save();

        return $this
            ->setReportFile($reportFile)
            ->setCollectedReportFile($collectedreportfile)
            ->setDynamicRow($dynamicrow)
            ->setDynamicValue($dynamicvalue);
    }*/

    public function setQueueCode(string|QueueEnum $queue_code = null): static
    {
        if ( ! is_null($queue_code) ) {
            $this->queue_code = $queue_code;
            $this->save();
        }

        return $this;
    }

    public function getReportfile(): ReportFile {
        if ( is_null($this->reportfile) ) {
            if ( is_null($this->treatment->reportfile) ) {
                $this->setReportFile($this->treatment->getMainTreatment()->reportfile);
            } else {
                $this->setReportFile($this->treatment->reportfile);
            }
        }
        return $this->reportfile;
    }

    public function execIdReset(): bool
    {
        $this->exec_id = 0;

        return $this->save();
    }

    /**
     * Get main service next exec id
     * @return int
     */
    public function getMainNextExecId(): int {
        return $this->treatment->getMainTreatment()->service->getNextExecId();
    }

    public function getFirstUpperNextExecId(): int {
        return $this->treatment->getFirstUpperTreatment()->service->getNextExecId();
    }

    public function getNextExecId(): int {
        if ( is_null($this->exec_id) ) {
            $this->exec_id = 0;
        }
        $this->exec_id += 1;
        $this->save();
        return $this->exec_id;
    }

    #endregion

    #region service Actions

    #endregion

    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::created(function ($model) {

        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {

        });
    }
}
