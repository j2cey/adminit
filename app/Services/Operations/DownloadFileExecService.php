<?php

namespace App\Services\Operations;

use App\Models\SystemLog;
use App\Enums\CriticalityLevelEnum;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Services\Steps\DownloadFileStepService;
use App\Models\ReportTreatments\TreatmentService;
use App\Contracts\RetrieveAction\IRetrieveAction;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class DownloadFileExecService extends DownloadFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public static function launch(Treatment $treatment): ?Treatment  {
        //ConsoleLog::info("DownloadFileStartService launched.");
        //\Log::info("launch, service DownloadFileStartService - treatment " . $treatment->type->value . ": " . $treatment->name . "( " . $treatment->id . " ) - file: " . $treatment->service->reportfile->name . "(" . $treatment->service->reportfile->id . ")" );
        return self::exec($treatment);
    }

    //public function exec(int $file_id, bool $is_last_subtreatment, bool $can_end_uppertreatment): ?IHasTreatmentResults
    public static function exec(Treatment $treatment): ?Treatment
    {
        //ConsoleLog::info("DownloadFileStartService executing...");
        //\Log::info("exec, service DownloadFileStartService - treatment " . $treatment->type->value . ": " . $treatment->name . "( " . $treatment->id . " ) - file: " . $treatment->service->reportfile->name . "(" . $treatment->service->reportfile->id . ")" );

        $treatment->refresh();
        if (  ! $treatment->canBeExecuted ) {
            return $treatment;
        }

        $reportfileaccess = $treatment->service->getReportfile()->getActiveReportFileAccess();

        try {
            $exec_id = 0;
            // 1. Définir le disk en fonction du protocole
            $remoteDisk = null;
            $get_disk = self::getDisk($reportfileaccess, $treatment, CriticalityLevelEnum::HIGH, ++$exec_id, [], false, false, $remoteDisk);
            if ( $get_disk->isSuccess() ) {
                // 2. Récupère l'action à exécuter pour la Récupération du fichier (retrieve_mode)
                $retrievemode_action = null;
                $get_retrievemode_action = self::getRetrieveModeAction($reportfileaccess, $treatment, CriticalityLevelEnum::HIGH, ++$exec_id, false, false, $retrievemode_action);

                if ( $get_retrievemode_action->isSuccess() ) {
                    // 3. Execute cette action (Telechargement effectif)
                    $execute_retrievemode = $retrievemode_action::execAction($remoteDisk, $treatment->service->getReportfile(), $treatment, CriticalityLevelEnum::HIGH, ++$exec_id, true,  true);
                    if ( $execute_retrievemode->isSuccess() ) {
                        // 4. dispatch de l'action a executer apres telechargement
                        $treatment->
                        launchNewSubOperation(TreatmentCodeEnum::DOWNLOADFILE_EXEC_AFTER, CriticalityLevelEnum::MEDIUM, ++$exec_id, true, true, [], true, false, false, null);
                    } else {
                        SystemLog::errorTreatments("Error EXEC Retrieve Action", TreatmentService::$TREATMENTSERVICE_LOG_INFO_PART);
                        $treatment->endingWithFailure( $execute_retrievemode->getResultMessage() );
                    }
                } else {
                    SystemLog::errorTreatments("Error GET Retrieve Action", TreatmentService::$TREATMENTSERVICE_LOG_INFO_PART);
                    $treatment->endingWithFailure( $get_retrievemode_action->getResultMessage() );
                }
            } else {
                SystemLog::errorTreatments("Error GET DISK", TreatmentService::$TREATMENTSERVICE_LOG_INFO_PART);
                $treatment->endingWithFailure($get_disk->getResultMessage());
            }
            return $treatment;
        } catch (\Exception $e) {
            \Log::error("DownloadFileExecService EXEC FAILED - " . $e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() . "; \n" . "Trace: " . $e->getTraceAsString());
            $treatment->endingWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
            return $treatment;
        }
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
