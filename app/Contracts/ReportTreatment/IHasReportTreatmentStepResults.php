<?php

namespace App\Contracts\ReportTreatment;

use App\Models\Status;
use App\Enums\TreatmentStepCode;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * @property ReportTreatmentStepResult[] $reportTreatmentStepResultsWaiting
 * @property ReportTreatmentStepResult[] $reportTreatmentStepResultsNotCompleted
 */
interface IHasReportTreatmentStepResults
{
    public function reporttreatmentstepresults();
    public function addReportTreatmentStepResult(Model|ReportTreatmentResult $reporttreatmentresult, TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false, Status $status = null): ReportTreatmentStepResult;

    public function reportTreatmentStepResultsWaiting();
    public function reportTreatmentStepResultsNotCompleted();
}
