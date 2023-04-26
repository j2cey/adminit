<?php

namespace App\Traits\ReportTreatmentResult;

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

    public function reportTreatmentStepResultsNotCompleted() {
        return $this->reporttreatmentstepresults()
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function addReportTreatmentStepResult(Model|ReportTreatmentResult $reporttreatmentresult, TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false, Status $status = null): ReportTreatmentStepResult
    {
        $reporttreatmentstepstoretry = $this->getReportTreatmentStepsToRetry();
        if ( count( $reporttreatmentstepstoretry ) === 0 ) {
            // if all step-results of this object are completed,
            // we add new one to the report-treatment-result
            $reporttreatmentstepresult = $reporttreatmentresult->addStep($code, $name, $criticality_level, $set_as_current_step);
            $this->reporttreatmentstepresults()->save($reporttreatmentstepresult);
        } else {
            //dd($getreporttreatmentstepstobecompleted);
            // else, we add a retry to the first incompleted step-result
            $reporttreatmentstepresult = $reporttreatmentstepstoretry[0]->addRetry($code, $name, $criticality_level);
        }

        if ( ! is_null($status) ) $reporttreatmentstepresult->status()->associate($status);

        return $reporttreatmentstepresult;
    }

    /**
     * @return ReportTreatmentStepResult[]|null
     */
    public function getReportTreatmentStepsToBeCompleted() {
        return $this->reporttreatmentstepresults()->active()->notCompleted()->notRunning()->get();
    }

    /**
     * @return ReportTreatmentStepResult[]|null
     */
    public function getReportTreatmentStepsToRetry() {
        return $this->reporttreatmentstepresults()->active()->notAlltried()->notRunning()->failed()->get();
            /*->withCount('retries')->having('retries_count', '>', '2')
            ->get();*/
    }

    protected function initializeHasReportTreatmentStepResults()
    {
        $this->with = array_unique(array_merge($this->with, ['reporttreatmentstepresults']));
    }
}
