<?php

namespace App\Models\Treatments;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Enums\Treatments\TreatmentCodeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

/**
 * Class TreatmentWorkflowStep
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string|TreatmentCodeEnum $code
 * @property string $name
 * @property integer $exec_posi workflow step position
 * @property string|CriticalityLevelEnum $criticality_level
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property TreatmentWorkflow $treatmentworkflow
 * @property TreatmentWorkflowStep $previousworkflowstep
 * @property TreatmentWorkflowStep $nextworkflowstep
 *
 * @method static TreatmentWorkflowStep create(null[]|string[] $array)
 */
class TreatmentWorkflowStep extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable; //, HasTreatmentStepService;

    protected $guarded = [];
    protected $with = ['treatmentworkflow'];
    protected $casts = [
        'code' => TreatmentCodeEnum::class,
        'criticality_level' => CriticalityLevelEnum::class,
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
        return $this->belongsTo(TreatmentWorkflow::class, "workflow_id");
    }
    public function previousworkflowstep() {
        return $this->belongsTo(TreatmentWorkflowStep::class, "previous_step_id");
    }
    public function nextworkflowstep() {
        return $this->belongsTo(TreatmentWorkflowStep::class, "next_step_id");
    }
    #endregion

    /**
     * @return ITreatmentStepService
     */
    /*public function treatmentstepservice() {
        return new $this->treatmentservice_class();
    }*/

    #region Custom Functions

    /**
     * Create a new TreatmentWorkflowStep Object
     * @param TreatmentWorkflow|Model $treatmentworkflow
     * @param string|TreatmentCodeEnum $code
     * @param CriticalityLevelEnum $criticality_level
     * @param string|null $name
     * @param Status|Model|null $status
     * @param string|null $description
     * @return TreatmentWorkflowStep
     */
    public static function createNew(TreatmentWorkflow|Model $treatmentworkflow, string|TreatmentCodeEnum $code, CriticalityLevelEnum $criticality_level, string $name = null, Status|Model $status = null, string $description = null): TreatmentWorkflowStep
    {
        $treatmentworkflowstep = TreatmentWorkflowStep::create([
            'code' => $code->value,
            'criticality_level' => $criticality_level,
            'name' => $name ?? "Etape " . $code->value,
            'description' => $description ?? "Etape " . $code->value . " du Worflow " . $treatmentworkflow->name,
        ]);

        $treatmentworkflowstep->treatmentworkflow()->associate($treatmentworkflow);

        $treatmentworkflowstep->status()->associate($status ?? Status::default()->first());
        $treatmentworkflowstep->save();

        return $treatmentworkflowstep;
    }

    /**
     * Update this TreatmentWorkflow Object
     * @param string|TreatmentCodeEnum $code
     * @param string|null $name
     * @param Status|Model|null $status
     * @param string|null $description
     * @return $this
     */
    public function updateThis(string|TreatmentCodeEnum $code, string $name = null, Status|Model $status = null, string $description = null): TreatmentWorkflowStep
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
     * @param TreatmentWorkflowStep|Model $previousworkflowstep
     * @return $this
     */
    public function setPreviousStep(TreatmentWorkflowStep|Model $previousworkflowstep): TreatmentWorkflowStep
    {
        $this->previousworkflowstep()->associate($previousworkflowstep);
        $this->save();

        return $this;
    }

    /**
     * Create and add a Previous Step to this Step
     * @param string|TreatmentCodeEnum $code
     * @param CriticalityLevelEnum $criticality_level
     * @param string|null $name
     * @param string|null $description
     * @return TreatmentWorkflowStep
     */
    public function addStepAsPrevious(string|TreatmentCodeEnum $code, CriticalityLevelEnum $criticality_level, string $name = null, string $description = null): TreatmentWorkflowStep {
        $previousworkflowstep = TreatmentWorkflowStep::createNew($this->treatmentworkflow, $code, $criticality_level, $name, Status::active()->first(), $description);
        $this->setPreviousStep($previousworkflowstep);

        return $previousworkflowstep;
    }

    /**
     * Set the Next Step after this step
     * @param TreatmentWorkflowStep|Model $nextworkflowstep
     * @return $this
     */
    public function setNextStep(TreatmentWorkflowStep|Model $nextworkflowstep): TreatmentWorkflowStep
    {
        $this->nextworkflowstep()->associate($nextworkflowstep);
        $this->save();

        return $this;
    }

    /**
     * Create and add a Next Step to this Step
     * @param string|TreatmentCodeEnum $code
     * @param CriticalityLevelEnum $criticality_level
     * @param string|null $name
     * @param string|null $description
     * @return TreatmentWorkflowStep
     */
    public function addStepAsNext(string|TreatmentCodeEnum $code, CriticalityLevelEnum $criticality_level, string $name = null, string $description = null): TreatmentWorkflowStep {
        $nextworkflowstep = TreatmentWorkflowStep::createNew($this->treatmentworkflow, $code, $criticality_level, $name, Status::active()->first(), $description);
        $this->setNextStep($nextworkflowstep);

        return $nextworkflowstep;
    }

    #endregion
}
