<?php

namespace App\Services\Steps;

use App\Enums\QueueEnum;
use App\Services\InnerTreatment;
use App\Services\TreatmentStage;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class ImportFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public ?TreatmentStage $stage;

    public Treatment $treatment;
    public int $exec_id;
    public ?CollectedReportFile $collected_report_file;

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
        $this->exec_id = 0;

        if ( is_null($treatment->service->collectedreportfile) ) {
            $treatment->service->setCollectedReportFile( $treatment->collectedreportfile );
            $this->collected_report_file = $treatment->service->collectedreportfile;
        }

        $this->initStages();
    }

    public function initStages() {
        $this->stage = new TreatmentStage($this->treatment, $this, TreatmentCodeEnum::IMPORTFILE->toArray()['name'], null);
        $this->stage->setFunction("prepareImport", CriticalityLevelEnum::HIGH, false, false, "Prepare File importation");

        /*$this->stage
            ->addNextStageOnSuccess("Launch Import Execution", "launchImportExec", CriticalityLevelEnum::HIGH, true, true,"Launch Import Execution");*/
    }

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::IMPORTFILE;
    }
    /*public static function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::IMPORTFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, $is_last_subtreatment, $can_end_uppertreatment, $nexttreatment_payloads, $dispatch_on_creation, false, false, null);
    }*/

    public function launch(Treatment $treatment): ?Treatment {
        return null; // self::launchExecOpertion($treatment, null, true, true, [], true);
    }

    public function exec(): ?Treatment {
        /*if ( $treatment->subtreatments()->waiting()->count() > 0 ) {
            $treatment->firstWaitingSubTreatment()->service->dispatch($treatment->reportfile);

            return $treatment;
        }*/
        //ConsoleLog::info("DownloadFileStepService executed - Nothing to do");

        if (!$this->treatment->canBeExecuted) {
            return $this->treatment;
        }

        $this->stage->exec();

        return $this->treatment;
    }

    #region Stage Functions
    public function prepareImport(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        $delete_imported_data = self::deleteImportedData($this->treatment->service->collectedreportfile, $this->treatment, $criticality_level, ++$this->exec_id, true, $is_last_subtreatment, $can_end_uppertreatment);
        if ( $delete_imported_data->isSuccess() ) {
            return 1;
        }
        return -1;
    }
    public function launchImportExec(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        $import_operation = $this->treatment->operationAddOrGet(TreatmentCodeEnum::IMPORTFILE_DOIMPORT, $criticality_level, ++$this->exec_id, $is_last_subtreatment, $can_end_uppertreatment, false, false, false, [], null);
        $import_operation->service->setReportFile($this->treatment->service->reportfile);
        $import_operation->service->setCollectedReportFile($this->treatment->service->collectedreportfile);

        return 1;
    }
    #endregion

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }

    #region Private Functions

    /**
     * Erase all imported data
     * @param CollectedReportFile $collectedreportfile
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticalitylevel
     * @param int $exec_id
     * @param bool $reset_imported
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @return InnerTreatment
     */
    public static function deleteImportedData(CollectedReportFile $collectedreportfile, Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, bool $reset_imported, bool $is_last_subtreatment = false, bool $can_end_uppertreatment = false): InnerTreatment
    {
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::IMPORT_START, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, null);
        if ( ! $reset_imported ) {
            return $innertreatment->succeed("Not to reset imported data !");
        }

        /*$operation = $treatment->operationAddOrGet(TreatmentCodeEnum::IMPORT_DEL, CriticalityLevelEnum::HIGH, $exec_id, $all_sub_treatments_launched, $can_end_upper_treatment, false, false, [], null)
            ->starting();*/

        try {
            $collectedreportfile->deleteRows();
            $collectedreportfile->lines_values = "[]";

            return $innertreatment->succeed( null );
        } catch (\Exception $e) {
            return $innertreatment->failed($e->getMessage());
        }
    }

    public static function isImportFileDone(Treatment $treatment): bool {
        return $treatment->service->collectedreportfile->isImported;
    }
    #endregion
}
