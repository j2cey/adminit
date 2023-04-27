<?php

namespace App\Traits\ReportTreatmentResult;

use Illuminate\Support\Carbon;
use App\Enums\TreatmentStateEnum;
use App\Enums\TreatmentResultEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

trait HasReportTreatmentResults
{
    public function reporttreatmentresults() {
        return $this->morphMany(ReportTreatmentResult::class, "hasreporttreatmentresults");
    }

    public function reportTreatmentResultsWaiting() {
        return $this->reporttreatmentresults()
            ->where('state', TreatmentStateEnum::WAITING->value);
    }

    public function reportTreatmentResultsNotCompleted() {
        return $this->reporttreatmentresults()
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function addReportTreatmentResult(string $name = null, Model|ReportTreatmentStepResult $currentstep = null, Carbon $start_at = null, Carbon $end_at = null, TreatmentStateEnum $state = null, TreatmentResultEnum $result = null, string $description = null): ReportTreatmentResult {
        $reporttreatmentresult = ReportTreatmentResult::createNew($name, $currentstep, $start_at, $end_at, $state, $result, $description);
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
