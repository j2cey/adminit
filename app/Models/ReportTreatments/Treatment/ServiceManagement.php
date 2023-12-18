<?php

namespace App\Models\ReportTreatments\Treatment;

use App\Models\Status;
use App\Enums\QueueEnum;
use App\Models\ReportFile\ReportFile;
use App\Models\DynamicValue\DynamicRow;
use App\Models\DynamicValue\DynamicValue;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\TreatmentService;

/**
 *
 */
trait ServiceManagement
{
    public function setService(string|TreatmentCodeEnum $code, ReportFile $reportFile = null, CollectedReportFile $collectedreportfile = null, DynamicRow $dynamicrow = null, DynamicValue $dynamicvalue = null, string|QueueEnum $queue_code = null, string $description = null, Status $status = null): TreatmentService {

        if ( is_null( $this->service ) ) {

            $service = TreatmentService::createNew($this, $code, $description);

            // set actions class
            if (class_exists($service->serviceactions_class)) {
                $service->setQueueCode($service->serviceactions_class::getQueueCode());
            }

            if ( ! is_null($status) ) $service->status()->associate($status);
            //->load(['reportfile','collectedreportfile'])
            /*$maintreatment = $this->getMainTreatment();
            $maintreatment->fresh();
            $maintreatment->load(['reportfile','collectedreportfile']);*/

            //$this->fresh();
            //$this->load(['reportfile','collectedreportfile']);

            $service
                ->setQueueCode($queue_code)
                ->setReportFile(is_null($reportFile) ? $this->reportfile : $reportFile )
                ->setCollectedReportFile( is_null($collectedreportfile) ? $this->collectedreportfile : $collectedreportfile )
                ->setDynamicRow( is_null($dynamicrow) ? $this->dynamicrow : $dynamicrow )
                ->setDynamicValue( is_null($dynamicvalue) ? $this->dynamicvalue : $dynamicvalue );

            //\Log::info( "Service created for " . $this->type->value . " " . $this->name . " ( " . $this->id . " ) . report_file_id: " . $service->report_file_id . ", collected_report_file_id: " . $service->collected_report_file_id . ", this report_file_id: " . $this->report_file_id . ", this collected_report_file_id: " . $this->collected_report_file_id );

            // dispatch treatment if any
            if ( $this->dispatch_on_creation ) {
                //$service->treatment()->save($this);
                $service->dispatch($this->reportfile);
            }

            if ( $this->launch_exec_operation_on_creation ) {
                $service->launchExecOpertion( json_decode( $this->payload, true ) , $this->service->getNextExecId(), $this->is_last_subtreatment, $this->can_end_uppertreatment, $this->dispatch_exec_operation_on_creation);
            }


            return $service;
        }
        return $this->service;
    }
}
