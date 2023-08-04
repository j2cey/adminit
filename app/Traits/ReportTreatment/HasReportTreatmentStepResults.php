<?php

namespace App\Traits\ReportTreatment;

use App\Models\Status;
use App\Enums\TreatmentStepCode;
use App\Enums\TreatmentStateEnum;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

trait HasReportTreatmentStepResults
{
    public function reporttreatmentstepresults() {
        return $this->morphMany(ReportTreatmentStepResult::class, 'hasreporttreatmentstepresults');
    }

    public function reportTreatmentStepResultsWaiting() {
        return $this->reporttreatmentstepresults()->waiting();
    }

    public function reportTreatmentStepResultsToRetry() {
        return $this->reporttreatmentstepresults()->waiting()->failed();
    }

    /**
     * @return ReportTreatmentStepResult
     */
    public function getFirstStepToRetry() {
        return $this->reportTreatmentStepResultsToRetry()->first();
    }

    public function reportTreatmentStepResultsNotCompleted() {
        return $this->reporttreatmentstepresults()
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function reportTreatmentStepsImport() {
        return $this->reporttreatmentstepresults()
            ->completed()
            ->success()
            ->whereIn('code', [TreatmentStepCode::DOWNLOADFILE->value]);
    }

    public function addReportTreatmentStepResult(Model|ReportTreatmentResult $reporttreatmentresult, TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false, Status $status = null): ReportTreatmentStepResult
    {
        if ( $this->reportTreatmentStepResultsToRetry()->count() > 0 ) {
            /**
             * we got at least one step waiting and failed,
             * so we retry it
             */
            $reporttreatmentstepresult = $this->getFirstStepToRetry();
        } else {
            $reporttreatmentstepresult = $reporttreatmentresult->addStep($code, $name, $criticality_level, $set_as_current_step);
            $this->reporttreatmentstepresults()->save($reporttreatmentstepresult);
        }

        if ( ! is_null($status) ) $reporttreatmentstepresult->status()->associate($status);

        return $reporttreatmentstepresult;
    }

    protected function initializeHasReportTreatmentStepResults()
    {
        $this->with = array_unique(array_merge($this->with, ['reporttreatmentstepresults']));
    }
}
