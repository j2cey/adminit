<?php

namespace App\Models\ReportTreatments;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Enums\Treatments\TreatmentCodeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TreatmentWorkflow
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
 * @method static TreatmentWorkflow create(null[]|string[] $array)
 * @property Report $report
 * @property TreatmentWorkflowStep $firstworkflowstep
 * @property TreatmentWorkflowStep[] $workflowsteps
 */
class TreatmentWorkflow extends BaseModel implements Auditable
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
        return $this->belongsTo(TreatmentWorkflowStep::class, "first_step_id");
    }
    public function workflowsteps() {
        return $this->hasMany(TreatmentWorkflowStep::class, "workflow_id");
    }
    public function hastreatmentworkflow()
    {
        return $this->morphTo();
    }
    #endregion

    #region Custom Functions

    /**
     * Create a new TreatmentWorkflow Object
     * @param string|null $name
     * @param Status|Model|null $status
     * @param string|null $description
     * @return TreatmentWorkflow
     */
    public static function createNew(string $name = null, Status|Model $status = null, string $description = null): TreatmentWorkflow
    {
        $data = [];
        $data['name'] = $name ?? "Workflow de Traitement";
        if ( ! is_null($description) ) $data['description'] = $name;

        $treatmentworkflow = TreatmentWorkflow::create($data);

        $treatmentworkflow->status()->associate($status ?? Status::default()->first());

        $treatmentworkflow->save();

        return $treatmentworkflow;
    }

    /**
     * Update this TreatmentWorkflow Object
     * @param string|null $name
     * @param Status|Model|null $status
     * @param string|null $description
     * @return $this
     */
    public function updateThis(string $name = null, Status|Model $status = null, string $description = null): TreatmentWorkflow
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
    public function setFirstStep(TreatmentWorkflowStep|Model $firstworkflowstep): TreatmentWorkflow
    {
        $this->firstworkflowstep()->associate($firstworkflowstep);
        $this->save();

        return $this;
    }

    /**
     * Create and add a First Step to this Workflow
     * @param string|TreatmentCodeEnum $code
     * @param CriticalityLevelEnum $criticality_level
     * @param string|null $name
     * @param string|null $description
     * @return TreatmentWorkflowStep
     */
    public function addStepAsFirst(string|TreatmentCodeEnum $code, CriticalityLevelEnum $criticality_level, string $name = null, string $description = null): TreatmentWorkflowStep {
        $firstworkflowstep = TreatmentWorkflowStep::createNew($this, $code, $criticality_level, $name, Status::default()->first(), $description);
        $this->setFirstStep($firstworkflowstep);

        return $firstworkflowstep;
    }

    public function getStepByCode(string|TreatmentCodeEnum $code): ?TreatmentWorkflowStep {
        return $this->workflowsteps()->where('code', $code->value)->first();
    }

    public function getNextStepFrom(string|TreatmentCodeEnum $code): ?TreatmentWorkflowStep {
        return $this->getStepByCode($code)?->nextworkflowstep;
    }

    #endregion
}
