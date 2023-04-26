<?php

namespace App\Contracts\ReportTreatmentResult;

use Illuminate\Support\Carbon;
use App\Enums\TreatmentStateEnum;
use App\Enums\TreatmentResultEnum;
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

    public function addReportTreatmentResult(string $name = null, Model|ReportTreatmentStepResult $currentstep = null, Carbon $start_at = null, Carbon $end_at = null, TreatmentStateEnum $state = null, TreatmentResultEnum $result = null, string $description = null): ReportTreatmentResult;
    public function getCurrentTreatmentReport();

    public function getReportTreatmentsToBeCompleted();
}
