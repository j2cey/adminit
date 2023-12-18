<?php

namespace App\Models\ReportTreatments\Treatment;

use App\Enums\CriticalityLevelEnum;
use App\Models\ReportFile\ReportFile;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentTypeEnum;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\ReportTreatments\TreatmentWorkflowStep;

trait MainTreatment
{
    public static function createMain(string $name, bool $dispatch_on_creation, array $payloads, ReportFile|null $reportfile, string|null $description): ?Treatment {
        $treatment = Treatment::createNew(null,TreatmentTypeEnum::Main, TreatmentCodeEnum::MAIN, CriticalityLevelEnum::HIGH, 0, true, true, $dispatch_on_creation, false, false, $payloads, $reportfile, $description, null);
        $treatment?->setName($name);

        return $treatment;
    }

    public function isLastWorkflowStep(TreatmentWorkflowStep $workflowstep): bool {
        return is_null($workflowstep->nextworkflowstep);
    }

    public function createFirstStep() {
        $first_workflowstep = $this->reportfile->report->getFirstWorkflowStep();

        return $this->stepAddOrGet($first_workflowstep->code, $first_workflowstep->criticality_level, 0, $this->isLastWorkflowStep($first_workflowstep), true, true, false, false, [], null);
    }

    public function firstWaitingSubTreatment(): Treatment {
        return $this->subtreatments()->waiting()->first();
    }

    /**
     * Get Main Treatment of given treatment
     * @return Treatment
     */
    public function getMainTreatment(): Treatment {
        if ( is_null($this->uppertreatment) ) {
            $this->fresh();
            return $this;
        }
        return $this->uppertreatment->getMainTreatment();
    }

    /**
     * Get the last upper treatment before Main (Main's 1st sub)
     * @return Treatment
     */
    public function getFirstUpperTreatment(): Treatment {
        $main = $this->getMainTreatment();

        if ( $this->uppertreatment->id == $main->id ) {
            return $this;
        }

        return $this->uppertreatment->getFirstUpperTreatment();
    }

    /*private function stepGetOrCreate(string|TreatmentCodeEnum $code, CriticalityLevelEnum|null $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_on_creation): Model|HasMany|Treatment|null
    {
        \Log::info("stepGetOrCreate, code: " . $code->value);
        /*$treatmentstep = $this->subtreatments()->where('code', $code->value)->first();
        if ( $treatmentstep ) {
            \Log::info("STEP FOUND");
            return $treatmentstep;
        }

        return $this->stepAddOrGet($code, is_null($criticality_level) ? CriticalityLevelEnum::MEDIUM : $criticality_level, 0, $is_last_subtreatment, $can_end_uppertreatment, $dispatch_on_creation, [], null);
    }*/

    public function getNextWorkflowStepFromTreatment(Treatment $treatment): ?TreatmentWorkflowStep {
        return $this->reportfile->report->getNextWorkflowStepFrom($treatment->code);
    }

    public function switchToNextStep(TreatmentWorkflowStep|null $workflowstep): ?Treatment {
        if ($workflowstep) {
            return $this->stepAddOrGet($workflowstep->code, $workflowstep->criticality_level, 0, $this->isLastWorkflowStep($workflowstep), true, true, false, false, [], null);
        }
        return null;
    }

    /*public function getOrCreateStepFromMain(TreatmentCodeEnum $treatment_code, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_on_creation): ?Treatment {
        //$workflowstep = $this->getMainTreatment()?->reportfile->report->getWorkflowStepByCode($treatment_code);
        \Log::info("getOrCreateStepFromMain, code: " . $treatment_code->value);
        return $this->getMainTreatment()?->stepAddOrGet($treatment_code, null, $is_last_subtreatment, $can_end_uppertreatment, $dispatch_on_creation);
    }*/
}
