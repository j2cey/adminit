<?php

namespace App\Services\Operations;


use App\Enums\CriticalityLevelEnum;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Services\Steps\DownloadFileStepService;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class DownloadFileAfterExecService extends DownloadFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public static function launch(Treatment $treatment): ?Treatment {
        //SystemLog::infoTreatments("launch, service DownloadFileAfterExec - " . $treatment->type->value . " treatment: " . $treatment->name . "( " . $treatment->id . " ) - file: " . $treatment->service->reportfile->name . "(" . $treatment->service->reportfile->id . ")", TreatmentService::$TREATMENTSERVICE_LOG_INFO_PART);
        return self::exec($treatment);
    }

    public static function exec(Treatment $treatment): ?Treatment
    {
        $exec_id = 0;
        //$this->initExecTreatment($file_id, $is_last_subtreatment, $can_end_uppertreatment);
        $reportfileaccess = $treatment->service->getReportfile()->getActiveReportFileAccess();

        $remoteDisk = null;
        $get_disk = self::getDisk($reportfileaccess, $treatment, CriticalityLevelEnum::HIGH, ++$exec_id, [], false, false, $remoteDisk);
        if ( $get_disk->isSuccess() ) {
            // 1. Récupère l'action à exécuter après la Récupération du fichier (to_perform_after_retrieving)
            $to_perform_after_retrieving = null;
            $get_retrievemode_action = self::getToPerformAfterRetrievingAction($treatment, CriticalityLevelEnum::HIGH, $reportfileaccess, false, false, $to_perform_after_retrieving);

            // 2. Execution de cette action
            if ( $get_retrievemode_action->isSuccess() ) {
                $to_perform_after_retrieving::execAction($remoteDisk, $treatment->service->getReportfile(), $treatment, CriticalityLevelEnum::LOW, ++$exec_id, true, true);
            }
        } else {
            $treatment->endingWithFailure( $get_disk->getResultMessage() );
        }

        return $treatment;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
