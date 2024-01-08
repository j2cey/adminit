<?php

namespace App\Services\Steps;

use App\Enums\QueueEnum;
use App\Services\InnerTreatment;
use App\Services\TreatmentStage;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\ReportFile\ReportFileAccess;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\RetrieveAction\RetrieveActionType;
use App\Contracts\RetrieveAction\IRetrieveAction;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class DownloadFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public ?TreatmentStage $stage;

    public Treatment $treatment;
    public ReportFileAccess $reportfileaccess;
    public int $exec_id;
    public ?Filesystem $disk;
    public IRetrieveAction|string|null $retrieve_mode_action;
    public ?CollectedReportFile $collected_report_file;
    public IRetrieveAction|string|null $retrieve_mode_action_after_download;


    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
        $this->reportfileaccess = $this->treatment->service->getReportfile()->getActiveReportFileAccess();
        $this->exec_id = 0;

        $this->initStages();
    }

    public function initStages() {
        $this->stage = new TreatmentStage($this->treatment, $this, TreatmentCodeEnum::DOWNLOADFILE->toArray()['name'], null);
        $this->stage->setFunction("getRemoteDisk", $this->treatment->criticality_level, $this->treatment->is_last_subtreatment, $this->treatment->can_end_uppertreatment, "Get Access Disk");

        $this->stage
            ->addNextStageOnSuccess("Get Retrieve Mode", "getRetrieveMode", CriticalityLevelEnum::HIGH, false, false,"Get the relevant s retrieve (download) mode")
            ->addNextStageOnSuccess("Download file and save new CollectedFile", "downloadFile", CriticalityLevelEnum::HIGH, false,  false, "Download file")
            ->addNextStageOnSuccess("Launch Import File Step", "launchImportFileStep", CriticalityLevelEnum::HIGH, false,  false, "launch Import File Step")
            ->addNextStageOnSuccess("Get After Download Action Mode", "getAfterDownloadActionMode", CriticalityLevelEnum::HIGH, false, false, "Get After Download ation Mode")
            ->addNextStageOnSuccess("Perform action after download", "performActionAfterDownloadFile", CriticalityLevelEnum::LOW, true, true, "Perform Action after Download file");
    }

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::DOWNLOADFILE;
    }

    public function launchExecOpertion_old(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::DOWNLOADFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, $is_last_subtreatment, $can_end_uppertreatment, $nexttreatment_payloads, $dispatch_on_creation,false, false, null);
    }

    public function launch(Treatment $treatment): ?Treatment {
        // Launch the step (operation) executor.
        return null;// self::launchExecOpertion($treatment, null, true, true, [], true);
    }

    public function exec(): ?Treatment {
        //Log::channel('stderr')->info('Something happened!');
        //ConsoleLog::info("DownloadFileStepService executing...");
        //ConsoleLog::warning("DownloadFileStepService executing...(warning)");
        //ConsoleLog::error("DownloadFileStepService executing...(error)");

        if (!$this->treatment->canBeExecuted) {
            return $this->treatment;
        }

        $this->stage->exec();

        /*if ( $treatment->subtreatments()->waiting()->count() > 0 ) {
            $treatment->firstWaitingSubTreatment()->service->dispatch($treatment->reportfile);

            return $treatment;
        }*/
        //ConsoleLog::info("DownloadFileStepService executed - Nothing to do");

        return $this->treatment;
    }

    public static function startExec() {

    }

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }

    #region Stage Functions
    public function getRemoteDisk(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int
    {
        $remoteDisk = null;
        $get_disk = self::getDisk($this->reportfileaccess, $this->treatment, CriticalityLevelEnum::HIGH, ++$this->exec_id, [], false, false, $remoteDisk);
        if ( $get_disk->isSuccess() ) {
            $this->disk = $remoteDisk;
            return 1;
        }
        return -1;
    }

    public function getRetrieveMode(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int
    {
        //\Log::info("getRetrieveMode - criticality_level: $criticality_level->value, is_last_subtreatment: " . ($is_last_subtreatment ? "true" : "false") . ", can_end_uppertreatment: " . $can_end_uppertreatment ? "true" : "false");
        $retrievemode_action = null;
        $get_retrievemode_action = self::getRetrieveModeAction($this->reportfileaccess, $this->treatment, $criticality_level, ++$this->exec_id, $is_last_subtreatment, $can_end_uppertreatment, $retrievemode_action);
        if ( $get_retrievemode_action->isSuccess() ) {
            $this->retrieve_mode_action = $retrievemode_action;
            return 1;
        }
        return -1;
    }

    public function downloadFile(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int
    {
        //\Log::info("downloadFile - criticality_level: $criticality_level->value, is_last_subtreatment: " . ($is_last_subtreatment ? "true" : "false") . ", can_end_uppertreatment: " . $can_end_uppertreatment ? "true" : "false");
        $execute_retrievemode = $this->retrieve_mode_action::execAction($this->disk, $this->treatment->service->getReportfile(), $this->treatment, $criticality_level, ++$this->exec_id, $is_last_subtreatment,  $can_end_uppertreatment);
        if ( $execute_retrievemode->isSuccess() ) {
            return 1;
        }
        return -1;
    }
    public function launchImportFileStep(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        $treatment_payloads = ['collectedReportFileId' => $this->treatment->collectedreportfile];
        $this->treatment->launchUpperStep(TreatmentCodeEnum::IMPORTFILE, $treatment_payloads, false, null);
        return 1;
    }

    public function getAfterDownloadActionMode(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int
    {
        //\Log::info("getAfterDownloadActionMode - criticality_level: $criticality_level->value, is_last_subtreatment: " . ($is_last_subtreatment ? "true" : "false") . ", can_end_uppertreatment: " . $can_end_uppertreatment ? "true" : "false");
        $to_perform_after_retrieving = null;
        $get_retrievemode_action = self::getToPerformAfterRetrievingAction($this->treatment, $criticality_level, $this->reportfileaccess, $is_last_subtreatment, $can_end_uppertreatment, $to_perform_after_retrieving);
        if ( $get_retrievemode_action->isSuccess() ) {
            $this->retrieve_mode_action_after_download = $to_perform_after_retrieving;
            return 1;
        }
        return -1;
    }

    public function performActionAfterDownloadFile(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int
    {
        //\Log::info("performActionAfterDownloadFile - criticality_level: $criticality_level->value, is_last_subtreatment: " . ($is_last_subtreatment ? "true" : "false") . ", can_end_uppertreatment: " . $can_end_uppertreatment ? "true" : "false");
        $to_perform_action = $this->retrieve_mode_action_after_download::execAction($this->disk, $this->treatment->service->getReportfile(), $this->treatment, $criticality_level, ++$this->exec_id, $is_last_subtreatment, $can_end_uppertreatment);
        return $to_perform_action->isSuccess() ? 1 : -1;
    }
    #endregion

    #region Step Functions
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
    #endregion
}
