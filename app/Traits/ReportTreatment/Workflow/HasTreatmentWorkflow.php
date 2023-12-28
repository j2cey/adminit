<?php

namespace App\Traits\ReportTreatment\Workflow;

use App\Models\Status;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\Treatments\TreatmentWorkflow;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Treatments\TreatmentWorkflowStep;

/**
 * @property TreatmentWorkflow $treatmentworkflow
 */
trait HasTreatmentWorkflow
{
    /**
     * @return MorphOne
     */
    public function treatmentworkflow()
    {
        return $this->morphOne(TreatmentWorkflow::class, 'hastreatmentworkflow');
    }

    public function setTreatmentWorkflow(string $name = null, Status|Model $status = null, string $description = null): ?TreatmentWorkflow {

        if ( is_null( $this->treatmentworkflow ) ) {
            $treatmentworkflow = TreatmentWorkflow::createNew($name, $status, $description);

            $this->treatmentworkflow()->save($treatmentworkflow);

            return $treatmentworkflow;
        }
        return $this->treatmentworkflow;
    }

    public function getFirstWorkflowStep(): ?TreatmentWorkflowStep {
        return $this->treatmentworkflow->firstworkflowstep;
    }

    /**
     * Get the next workflow step after the given step having the given code
     * @param TreatmentCodeEnum $code
     * @return TreatmentWorkflowStep|null
     */
    public function getNextWorkflowStepFrom(TreatmentCodeEnum $code): ?TreatmentWorkflowStep {
        return $this->treatmentworkflow->getNextStepFrom($code);
    }

    /**
     * Get the next workflow step after the given step having the given code
     * @param TreatmentCodeEnum $code
     * @return TreatmentWorkflowStep|null
     */
    public function getWorkflowStepByCode(TreatmentCodeEnum $code): ?TreatmentWorkflowStep {
        return $this->treatmentworkflow->getStepByCode($code);
    }

    public function setDefaultTreatmentWorkflowSteps(): ?TreatmentWorkflow
    {
        $treatmentworkflow = $this->setTreatmentWorkflow();

        $treatmentworkflow->addStepAsFirst(TreatmentCodeEnum::DOWNLOADFILE, CriticalityLevelEnum::HIGH)
            ->addStepAsNext(TreatmentCodeEnum::IMPORTFILE, CriticalityLevelEnum::HIGH)
            ->addStepAsNext(TreatmentCodeEnum::MERGEFILE, CriticalityLevelEnum::HIGH)
        //    ->addStepAsNext(TreatmentCodeEnum::NOTIFYFILE, CriticalityLevelEnum::HIGH)
        ;

        return $treatmentworkflow;
    }

    #region booting

    protected function initializeHasTreatmentWorkflow()
    {
        $this->with = array_unique(array_merge($this->with, ['treatmentworkflow']));
    }

    public static function bootHasTreatmentWorkflow()
    {
        static::created(function ($model) {
            $model->setDefaultTreatmentWorkflowSteps();
        });
    }

    #endregion
}
