<?php

namespace App\Traits\ReportTreatment;

use App\Models\Reports\Report;
use App\Enums\TreatmentStateEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * @property ReportTreatmentResult[] $reportTreatmentResultsNotCompleted
 * @property ReportTreatmentResult[] $reportTreatmentResultsWaiting
 */
trait HasReportTreatmentResults
{
    public function reporttreatmentresults() {
        return $this->morphMany(ReportTreatmentResult::class, "hasreporttreatmentresults");
    }

    public function reportTreatmentResultsWaiting() {
        return $this->reporttreatmentresults()
            ->active()->waiting();
            //->where('state', TreatmentStateEnum::WAITING->value);
    }

    public function reportTreatmentResultsRunning() {
        return $this->reporttreatmentresults()
            ->active()->running();
    }

    public function reportTreatmentResultsQueued() {
        return $this->reporttreatmentresults()
            ->active()->queued();
    }

    public function reportTreatmentResultsNotCompleted() {
        return $this->reporttreatmentresults()
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function addReportTreatmentResult(Model|Report $report, string $name = null, Model|ReportTreatmentStepResult $currentstep = null, string $description = null): ReportTreatmentResult {
        $reporttreatmentresult = ReportTreatmentResult::createNew($report, $name, $currentstep, $description);
        $this->reporttreatmentresults()->save($reporttreatmentresult);

        return $reporttreatmentresult;
    }

    /**
     * @return ReportTreatmentResult|null
     */
    public function getCurrentTreatmentReport() {
        return $this->reporttreatmentresults()->active()->waiting()->first();
    }

    /**
     * @return ReportTreatmentResult[]|null
     */
    public function getReportTreatmentsToBeCompleted() {
        return $this->reporttreatmentresults()->active()->notCompleted()->notRunning()->notQueued()->get();
    }

    protected function initializeHasReportTreatmentResults()
    {
        $this->with = array_unique(array_merge($this->with, ['reporttreatmentresults']));
    }
}
