<?php

namespace App\Contracts\ReportTreatment;

use App\Models\Reports\Report;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * @property ReportTreatmentResult[] $reportTreatmentResultsWaiting
 * @property ReportTreatmentResult[] $reportTreatmentResultsNotCompleted
 */
interface IHasReportTreatmentResults
{
    public function reporttreatmentresults();
    public function reportTreatmentResultsWaiting();
    public function reportTreatmentResultsNotCompleted();

    public function addReportTreatmentResult(Model|Report $report, string $name = null, Model|ReportTreatmentStepResult $currentstep = null, string $description = null): ReportTreatmentResult;
    public function getCurrentTreatmentReport();

    public function getReportTreatmentsToBeCompleted();
}
