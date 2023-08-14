<?php

namespace App\Traits\ReportTreatment;

use App\Models\Status;
use App\Enums\TreatmentStepCode;
use App\Enums\TreatmentStateEnum;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

trait HasReportTreatmentSteps
{
    public function reporttreatmentsteps() {
        return $this->morphMany(ReportTreatmentStep::class, 'hasreporttreatmentsteps');
    }

    public function reportTreatmentStepsWaiting() {
        return $this->reporttreatmentsteps()->waiting();
    }

    public function reportTreatmentStepsToRetry() {
        return $this->reporttreatmentsteps()->waiting()->failed();
    }

    /**
     * @return ReportTreatmentStep
     */
    public function getFirstStepToRetry() {
        return $this->reportTreatmentStepsToRetry()->first();
    }

    public function reportTreatmentStepsNotCompleted() {
        return $this->reporttreatmentsteps()
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function reportTreatmentStepsImport() {
        return $this->reporttreatmentsteps()
            ->completed()
            ->success()
            ->whereIn('code', [TreatmentStepCode::DOWNLOADFILE->value]);
    }

    public function addReportTreatmentStep(Model|ReportTreatment $reporttreatment, TreatmentStepCode $code, string $name = null, CriticalityLevelEnum $criticality_level = null, bool $set_as_current_step = false, Status $status = null): ReportTreatmentStep
    {
        if ( $this->reportTreatmentStepsToRetry()->count() > 0 ) {
            /**
             * we got at least one step waiting and failed,
             * so we retry it
             */
            $reporttreatmentstep = $this->getFirstStepToRetry();
        } else {
            $reporttreatmentstep = $reporttreatment->addStep($code, $name, $criticality_level, $set_as_current_step);
            $this->reporttreatmentsteps()->save($reporttreatmentstep);
        }

        if ( ! is_null($status) ) $reporttreatmentstep->status()->associate($status);

        return $reporttreatmentstep;
    }

    protected function initializeHasReportTreatmentSteps()
    {
        $this->with = array_unique(array_merge($this->with, ['reporttreatmentsteps']));
    }
}
