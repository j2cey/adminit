<?php

namespace App\Traits\ReportTreatment;

use App\Models\Reports\Report;
use App\Enums\TreatmentStateEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * @property ReportTreatment[] $reportTreatmentsNotCompleted
 * @property ReportTreatment[] $reportTreatmentsWaiting
 */
trait HasReportTreatments
{
    public function reporttreatments() {
        return $this->morphMany(ReportTreatment::class, "hasreporttreatments");
    }

    public function reportTreatmentsWaiting() {
        return $this->reporttreatments()
            ->active()->waiting();
            //->where('state', TreatmentStateEnum::WAITING->value);
    }

    public function reportTreatmentsRunning() {
        return $this->reporttreatments()
            ->active()->running();
    }

    public function reportTreatmentsQueued() {
        return $this->reporttreatments()
            ->active()->queued();
    }

    public function reportTreatmentsNotCompleted() {
        return $this->reporttreatments()
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function addReportTreatment(Model|Report $report, string $name = null, Model|ReportTreatmentStep $currentstep = null, string $description = null): ReportTreatment {
        $reporttreatment = ReportTreatment::createNew($report, $name, $currentstep, $description);
        $this->reporttreatments()->save($reporttreatment);

        return $reporttreatment;
    }

    /**
     * @return ReportTreatment|null
     */
    public function getCurrentTreatmentReport() {
        return $this->reporttreatments()->active()->waiting()->first();
    }

    /**
     * @return ReportTreatment[]|null
     */
    public function getReportTreatmentsToBeCompleted() {
        return $this->reporttreatments()->active()->notCompleted()->notRunning()->notQueued()->get();
    }

    protected function initializeHasReportTreatments()
    {
        $this->with = array_unique(array_merge($this->with, ['reporttreatments']));
    }
}
