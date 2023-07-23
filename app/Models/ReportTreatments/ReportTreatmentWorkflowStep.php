<?php

namespace App\Models\ReportTreatments;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Enums\TreatmentStepCode;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportTreatmentWorkflowStep
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string|TreatmentStepCode $code
 * @property string $name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ReportTreatmentWorkflow $treatmentworkflow
 * @property ReportTreatmentWorkflowStep $previousworkflowstep
 * @property ReportTreatmentWorkflowStep $nextworkflowstep
 *
 * @method static ReportTreatmentWorkflowStep create(null[]|string[] $array)
 */
class ReportTreatmentWorkflowStep extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['treatmentworkflow'];
    protected $casts = [
        'code' => TreatmentStepCode::class,
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'code' => ['required']
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
            'code.required' => "Prière de renseigner le code de l'étape"
        ];
    }

    #endregion

    #region Accessors & Mutators

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships
    public function treatmentworkflow() {
        return $this->belongsTo(ReportTreatmentWorkflow::class, "workflow_id");
    }
    public function previousworkflowstep() {
        return $this->belongsTo(ReportTreatmentWorkflowStep::class, "previous_step_id");
    }
    public function nextworkflowstep() {
        return $this->belongsTo(ReportTreatmentWorkflowStep::class, "next_step_id");
    }
    #endregion

    #region Custom Functions

    /**
     * Create a new ReportTreatmentWorkflowStep Object
     * @param ReportTreatmentWorkflow|Model $treatmentworkflow
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param Status|Model|null $status
     * @param string|null $description
     * @return ReportTreatmentWorkflowStep
     */
    public static function createNew(ReportTreatmentWorkflow|Model $treatmentworkflow, TreatmentStepCode $code, string $name = null, Status|Model $status = null, string $description = null): ReportTreatmentWorkflowStep
    {
        $reporttreatmentworkflowstep = ReportTreatmentWorkflowStep::create([
            'code' => $code->value,
            'name' => $name ?? "Etape " . $code->value,
            'description' => $description ?? "Etape " . $code->value . " du Worflow " . $treatmentworkflow->name,
        ]);

        $reporttreatmentworkflowstep->treatmentworkflow()->associate($treatmentworkflow);

        $reporttreatmentworkflowstep->status()->associate($status ?? Status::default()->first());
        $reporttreatmentworkflowstep->save();

        return $reporttreatmentworkflowstep;
    }

    /**
     * Update this ReportTreatmentWorkflow Object
     * @param string|null $name
     * @param string|null $description
     * @return $this
     */
    public function updateThis(TreatmentStepCode $code, string $name = null, Status|Model $status = null, string $description = null): ReportTreatmentWorkflowStep
    {
        $this->name = $code;
        $this->name = $name ?? $this->name;
        $this->description =  $description ?? $this->description;

        $this->status()->associate($status ?? $this->status );
        $this->save();

        return $this;
    }

    /**
     * Set the Previous Step before this step
     * @param ReportTreatmentWorkflowStep|Model $previousworkflowstep
     * @return $this
     */
    public function setPreviousStep(ReportTreatmentWorkflowStep|Model $previousworkflowstep): ReportTreatmentWorkflowStep
    {
        $this->previousworkflowstep()->associate($previousworkflowstep);
        $this->save();

        return $this;
    }

    /**
     * Create and add a Previous Step to this Step
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param string|null $description
     * @return ReportTreatmentWorkflowStep
     */
    public function addStepAsPrevious(TreatmentStepCode $code, string $name = null, string $description = null): ReportTreatmentWorkflowStep {
        $previousworkflowstep = ReportTreatmentWorkflowStep::createNew($this->treatmentworkflow, $code, $name, Status::active()->first(), $description);
        $this->setPreviousStep($previousworkflowstep);

        return $previousworkflowstep;
    }

    /**
     * Set the Next Step after this step
     * @param ReportTreatmentWorkflowStep|Model $nextworkflowstep
     * @return $this
     */
    public function setNextStep(ReportTreatmentWorkflowStep|Model $nextworkflowstep): ReportTreatmentWorkflowStep
    {
        $this->nextworkflowstep()->associate($nextworkflowstep);
        $this->save();

        return $this;
    }

    /**
     * Create and add a Next Step to this Step
     * @param TreatmentStepCode $code
     * @param string|null $name
     * @param string|null $description
     * @return ReportTreatmentWorkflowStep
     */
    public function addStepAsNext(TreatmentStepCode $code, string $name = null, string $description = null): ReportTreatmentWorkflowStep {
        $nextworkflowstep = ReportTreatmentWorkflowStep::createNew($this->treatmentworkflow, $code, $name, Status::active()->first(), $description);
        $this->setNextStep($nextworkflowstep);

        return $nextworkflowstep;
    }

    #endregion
}
