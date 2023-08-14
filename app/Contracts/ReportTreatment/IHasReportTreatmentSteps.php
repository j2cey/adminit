<?php

namespace App\Contracts\ReportTreatment;

use App\Models\Status;
use App\Enums\TreatmentStepCode;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * @property ReportTreatmentStep[] $reportTreatmentStepsWaiting
 * @property ReportTreatmentStep[] $reportTreatmentStepsNotCompleted
 */
interface IHasReportTreatmentSteps
{
    public function reporttreatmentsteps();
    public function addReportTreatmentStep(Model|ReportTreatment $reporttreatmentresult, TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false, Status $status = null): ReportTreatmentStep;

    public function reportTreatmentStepsWaiting();
    public function reportTreatmentStepsNotCompleted();
}
