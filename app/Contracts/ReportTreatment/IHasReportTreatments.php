<?php

namespace App\Contracts\ReportTreatment;

use App\Models\Reports\Report;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * @property ReportTreatment[] $reportTreatmentsWaiting
 * @property ReportTreatment[] $reportTreatmentsNotCompleted
 */
interface IHasReportTreatments
{
    public function reporttreatments();
    public function reportTreatmentsWaiting();
    public function reportTreatmentsNotCompleted();

    public function addReportTreatment(Model|Report $report, string $name = null, Model|ReportTreatmentStep $currentstep = null, string $description = null): ReportTreatment;
    public function getCurrentTreatmentReport();

    public function getReportTreatmentsToBeCompleted();
}
