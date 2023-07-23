<?php

namespace App\Models\ReportTreatments;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Enums\TreatmentStepCode;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportTreatmentWorkflow
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ReportTreatmentWorkflow create(null[]|string[] $array)
 * @property Report $report
 * @property ReportTreatmentWorkflowStep $firstworkflowstep
 * @property ReportTreatmentWorkflowStep[] $workflowsteps
 */
class ReportTreatmentWorkflow extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

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
    public function firstworkflowstep() {
        return $this->belongsTo(ReportTreatmentWorkflowStep::class, "first_step_id");
    }
    public function workflowsteps() {
        return $this->hasMany(ReportTreatmentWorkflowStep::class, "workflow_id");
    }
    public function report() {
        return $this->belongsTo(Report::class, "report_id");
    }
    #endregion

    #region Custom Functions

    /**
     * Create a new ReportTreatmentWorkflow Object
     * @param Report|Model $report
     * @param string|null $name
     * @param Status|Model|null $status
     * @param string|null $description
     * @return ReportTreatmentWorkflow
     */
    public static function createNew(Report|Model $report, string $name = null, Status|Model $status = null, string $description = null): ReportTreatmentWorkflow
    {
        $data = [];
        $data['name'] = $name ?? "Workflow de Traitement, Rapport " . $report->title;
        if ( ! is_null($description) ) $data['description'] = $name;

        $reporttreatmentworkflow = ReportTreatmentWorkflow::create($data);

        $reporttreatmentworkflow->report()->associate($report);
        $reporttreatmentworkflow->status()->associate($status ?? Status::default()->first());

        $reporttreatmentworkflow->save();

        return $reporttreatmentworkflow;
    }

    /**
     * Update this ReportTreatmentWorkflow Object
     * @param string|null $name
     * @param Status|Model|null $status
     * @param string|null $description
     * @return $this
     */
    public function updateThis(string $name = null, Status|Model $status = null, string $description = null): ReportTreatmentWorkflow
    {
        $this->name = $name ?? $this->name;
        $this->description =  $description ?? $this->description;

        $this->status()->associate($status ?? $this->status );
        $this->save();

        return $this;
    }

    /**
     * Start the treatment of this OperationResult object
     * @return $this
     */
    public function setFirstStep(ReportTreatmentWorkflowStep|Model $firstworkflowstep): ReportTreatmentWorkflow
    {
        $this->firstworkflowstep()->associate($firstworkflowstep);
        $this->save();

        return $this;
    }

    /**
     * Create and add a First Step to this Workflow
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param string|null $description
     * @return ReportTreatmentWorkflowStep
     */
    public function addStepAsFirst(TreatmentStepCode $code, string $name = null, string $description = null): ReportTreatmentWorkflowStep {
        $firstworkflowstep = ReportTreatmentWorkflowStep::createNew($this, $code, $name, Status::default()->first(), $description);
        $this->setFirstStep($firstworkflowstep);

        return $firstworkflowstep;
    }

    #endregion

    public static function createDefaultTreatmentWorkflow(Report|Model $report, string $name = null, Status $status = null, string $description = null): ReportTreatmentWorkflow {
        $reporttreatmentworkflow = ReportTreatmentWorkflow::createNew($report, $name, $status, $description);

        $reporttreatmentworkflow->addStepAsFirst(TreatmentStepCode::DOWNLOADFILE)
            ->addStepAsNext(TreatmentStepCode::IMPORTFILE)
            ->addStepAsNext(TreatmentStepCode::MERGEROWS)
            ->addStepAsNext(TreatmentStepCode::NOTIFYFILE);

        return $reporttreatmentworkflow;
    }
}
