<?php

namespace App\Traits\ReportTreatmentStepResult;

use App\Models\Status;
use App\Enums\TreatmentStepCode;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

trait HasReportTreatmentStepResults
{
    public function reporttreatmentstepresults() {
        return $this->morphMany(ReportTreatmentStepResult::class, 'hasreporttreatmentstepresults');
    }

    public function addReportTreatmentStepResult(Model|ReportTreatmentResult $reporttreatmentresult, TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false, Status $status = null): ReportTreatmentStepResult
    {
        $reporttreatmentstepresult = $reporttreatmentresult->addStep($code, $name, $criticality_level, $set_as_current_step);

        $this->reporttreatmentstepresults()->save($reporttreatmentstepresult);

        if ( ! is_null($status) ) $reporttreatmentstepresult->status()->associate($status);

        return $reporttreatmentstepresult;
    }

    protected function initializeHasReportTreatmentStepResults()
    {
        $this->with = array_unique(array_merge($this->with, ['reporttreatmentstepresults']));
    }
}
