<?php

namespace App\Services\Steps;

use App\Enums\QueueEnum;
use App\Services\InnerTreatment;
use App\Enums\CriticalityLevelEnum;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\ReportFile\ReportFileAccess;
use App\Enums\Treatments\TreatmentResultEnum;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\RetrieveAction\RetrieveActionType;
use App\Contracts\RetrieveAction\IRetrieveAction;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class DownloadFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::DOWNLOADFILE;
    }

    public static function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::DOWNLOADFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, $is_last_subtreatment, $can_end_uppertreatment, $nexttreatment_payloads, $dispatch_on_creation,false, false, null);
    }

    public static function launch(Treatment $treatment): ?Treatment {
        // Launch the step (operation) executor.
        return self::launchExecOpertion($treatment, null, true, true, [], true);
    }

    public static function exec(Treatment $treatment): ?Treatment {
        //Log::channel('stderr')->info('Something happened!');
        //ConsoleLog::info("DownloadFileStepService executing...");
        //ConsoleLog::warning("DownloadFileStepService executing...(warning)");
        //ConsoleLog::error("DownloadFileStepService executing...(error)");

        if ( $treatment->subtreatments()->waiting()->count() > 0 ) {
            $treatment->firstWaitingSubTreatment()->service->dispatch($treatment->reportfile);

            return $treatment;
        }
        //ConsoleLog::info("DownloadFileStepService executed - Nothing to do");
        return $treatment;
    }

    public static function startExec() {

    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }

    /**
     * @param ReportFileAccess $reportfileaccess
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticality_level
     * @param int $exec_id
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param IRetrieveAction|string|null $retrievemode_action
     * @return InnerTreatment
     */
    public static function getRetrieveModeAction(ReportFileAccess $reportfileaccess, Treatment $treatment, CriticalityLevelEnum $criticality_level, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, IRetrieveAction|string|null &$retrievemode_action): InnerTreatment
    {
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::DOWNLOADFILE_RETRIEVEMODEACTION_GET, $criticality_level, $is_last_subtreatment, $can_end_uppertreatment, true, null);
        try {

            foreach ($reportfileaccess->selectedretrieveactions as $selectedretrieveaction) {
                if ( $selectedretrieveaction->retrieveaction->retrieveactiontype->code === RetrieveActionType::retrieveMode()->first()->code ) {
                    //$treatment->getMainTreatment()->addPayloads(['RetrieveModeAction' => $selectedretrieveaction->retrieveaction->name]);
                    //$operation->endingWithSuccess("Succes - " . $selectedretrieveaction->retrieveaction->retrieveactiontype->name . " " . $selectedretrieveaction->retrieveaction->name);

                    $retrievemode_action = $selectedretrieveaction->retrieveaction->action_class;

                    return $innertreatment->succeed("Succes - " . $selectedretrieveaction->retrieveaction->retrieveactiontype->name . " " . $selectedretrieveaction->retrieveaction->name);
                }
            }

            return $innertreatment->failed("Aucune action ne match !");
        } catch (\Exception $e) {
            return $innertreatment->failed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
            //return null;
        }
    }

    /**
     * @param ReportFileAccess $reportfileaccess
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticality_level
     * @param int $exec_id
     * @param array $treatment_payloads
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param Filesystem|null $disk
     * @return InnerTreatment
     */
    public static function getDisk(ReportFileAccess $reportfileaccess, Treatment $treatment, CriticalityLevelEnum $criticality_level, int $exec_id, array $treatment_payloads, bool $is_last_subtreatment, bool $can_end_uppertreatment, Filesystem|null &$disk): InnerTreatment {
        return $reportfileaccess->accessprotocole->innerprotocole()::getDisk($treatment, $criticality_level, $exec_id, $treatment_payloads, $reportfileaccess->accessaccount, $reportfileaccess->reportserver, $reportfileaccess->port, $is_last_subtreatment, $can_end_uppertreatment, $disk);
    }

    /**
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticality_level
     * @param ReportFileAccess $reportfileaccess
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param $retrievemode_action
     * @return InnerTreatment
     */
    public static function getToPerformAfterRetrievingAction(Treatment $treatment, CriticalityLevelEnum $criticality_level, ReportFileAccess $reportfileaccess, bool $is_last_subtreatment, bool $can_end_uppertreatment, &$retrievemode_action): InnerTreatment
    {
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::DOWNLOADFILE_RETRIEVEMODEACTION_AFTEREXEC_GET, $criticality_level, $is_last_subtreatment, $can_end_uppertreatment, true, null);

        foreach ($reportfileaccess->selectedretrieveactions as $selectedretrieveaction) {
            if ( $selectedretrieveaction->retrieveaction->retrieveactiontype->code === RetrieveActionType::toPerformAfterRetrieving()->first()->code ) {
                $retrievemode_action = $selectedretrieveaction->retrieveaction->action_class;

                return $innertreatment->succeed("Succes - " . $selectedretrieveaction->retrieveaction->retrieveactiontype->name . " " . $selectedretrieveaction->retrieveaction->name);
            }
        }

        return $innertreatment->failed("Aucune action ne match !");

        /*$to_perform_after_retrieving = $this->selectedretrieveactions()->with( [ 'retrieveaction' => function( $query ) {
            $query->with(['retrieveactiontype' => function ($query) {
                RetrieveActionType::toPerformAfterRetrieving($query);
            }]);
        }])->first();
        return $to_perform_after_retrieving->retrieveaction->action_class ?? null;*/
    }
}
