<?php

namespace App\Services\Operations;

use App\Enums\CriticalityLevelEnum;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Services\Steps\ImportFileStepService;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class ImportFileExecService extends ImportFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public static function launch(Treatment $treatment): ?Treatment  {
        return self::exec($treatment);
    }

    public static function exec(Treatment $treatment): ?Treatment
    {
        try {

            $exec_id = 0;

            if ( is_null($treatment->service->collectedreportfile) ) {
                $treatment->service->setCollectedReportFile( $treatment->collectedreportfile );
            }

            //$start_import = self::startImport($treatment->service->collectedreportfile, $treatment, CriticalityLevelEnum::MEDIUM, ++$exec_id, false, false, true);

            //if ( $start_import->isSuccess() ) {

                $delete_imported_data = self::deleteImportedData($treatment->service->collectedreportfile, $treatment, CriticalityLevelEnum::HIGH, ++$exec_id, true, false, false);
                if ( $delete_imported_data->isSuccess() ) {

                    $import_operation = $treatment->operationAddOrGet(TreatmentCodeEnum::IMPORTFILE_DOIMPORT, CriticalityLevelEnum::HIGH, ++$exec_id, true, true, false, false, false, [], null);
                    $import_operation->service->setReportFile($treatment->service->reportfile);
                    $import_operation->service->setCollectedReportFile($treatment->service->collectedreportfile);

                    //Excel::queue( new ReportFileImport($treatment->service->collectedreportfile, $import_operation), $treatment->service->collectedreportfile->fileLocalAbsolutePath )->onQueue( JobLauncher::getLauncher($treatment->service->queue_code)->getQueueName() );
                    //(new ReportFileImport($treatment->service->collectedreportfile, $import_operation))->queue($treatment->service->collectedreportfile->fileLocalAbsolutePath)->onQueue( JobLauncher::getLauncher($treatment->service->queue_code)->getQueueName() );

                    //$import_operation->service->dispatch($import_operation->service->reportfile);
                    //(new ReportFileImport($treatment->service->collectedreportfile, $import_operation))->import($treatment->service->collectedreportfile->fileLocalAbsolutePath);
                    //$import_operation->endingWithSuccess("Fin exécution ReportFileLinesImport");

                    //$this->_collected_file->endImport($this->_step, true, true, true);

                    //SymphonyProcess::runBackgroundProcess("reportfile:import", $treatment->id);
                }
            //} else {
            //    $treatment->endingWithFailure( $start_import->getResultMessage() );
            //}
            return $treatment;
        } catch (\Exception $e) {
            //$this->_collected_file->endImport($this->_step, true, true, $dispatch_next_step);
            $treatment->endingWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
            return $treatment;
        }
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
