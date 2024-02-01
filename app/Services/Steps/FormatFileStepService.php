<?php

namespace App\Services\Steps;

use Throwable;
use App\Enums\Settings;
use App\Enums\QueueEnum;
use Illuminate\Bus\Batch;
use App\Services\TreatmentStage;
use App\Enums\CriticalityLevelEnum;
use App\Jobs\DynamicValueFormatJob;
use Illuminate\Support\Facades\Bus;
use App\Models\Treatments\Treatment;
use App\Models\DynamicValue\DynamicRow;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class FormatFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public ?TreatmentStage $stage;

    public int $treatment_id;
    public int $exec_id;
    public ?int $collected_report_file_id;

    public int $import_queue_id = 0;

    public int $nb_rows_to_process = 0;
    public int $nb_rows_processed = 0;

    public int $nb_values_to_process = 0;
    public int $nb_values_processed = 0;

    public function __construct(Treatment $treatment)
    {
        $this->treatment_id = $treatment->id;
        $this->exec_id = 0;

        if ( is_null($treatment->service->collectedreportfile) ) {
            $treatment->service->setCollectedReportFile( $treatment->collectedreportfile );
            $this->collected_report_file_id = $treatment->service->collectedreportfile->id;
        }

        $this->initStages();
    }

    public function initStages() {
        $this->stage = new TreatmentStage(Treatment::getById($this->treatment_id), $this, TreatmentCodeEnum::IMPORTFILE->toArray()['name'], null, true);
        $this->stage->setFunction("launchFormatRows", CriticalityLevelEnum::HIGH, false, false, null, "Launch File formatting");
    }

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::FORMATFILE;
    }

    public function launch(Treatment $treatment): ?Treatment {
        return null;
    }

    public function exec(): ?Treatment {
        $treatment = Treatment::getById($this->treatment_id);
        if (!$treatment->canBeExecuted) {
            return $treatment;
        }

        $treatment->starting();
        $this->stage->exec($treatment->break_point);

        return $treatment;
    }

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }

    public function getNextOnSuccess(): ?TreatmentCodeEnum
    {
        return TreatmentCodeEnum::MERGEFILE;
    }

    public function launchNextOnSuccess(array $payloads)
    {
        $treatment = Treatment::getById($this->treatment_id);

        $treatment->reloadCollectedreportfile();
        $payloads = self::addCollectedReportFileToPayload($payloads, $treatment->collectedreportfile);
        $treatment->launchUpperStep($this->getNextOnSuccess(), false, true, $payloads, false, null);
    }

    public function getNextOnFailure(): ?TreatmentCodeEnum
    {
        return null;
    }

    public function launchNextOnFailure(array $payloads)
    {
        // TODO: Implement launchNextOnFailure() method.
    }

    #region Stage Functions
    public function launchFormatRows(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        $treatment = Treatment::getById($this->treatment_id);
        $dynamicrows = $treatment->collectedreportfile->dynamicrows;
        foreach ($dynamicrows as $dynamicrow) {
            $this->formatRowValuesLaunch($treatment,$treatment->collectedreportfile,$dynamicrow);
        }
        return 1;
    }
    #endregion

    #region Custom local functions
    private function formatRowValuesLaunch(Treatment $treatment, CollectedReportFile $collectedreportfile, DynamicRow $dynamicrow) {

        $progression_step_name = "format row " . $dynamicrow->line_num . "(" . $dynamicrow->id . ")";
        $treatment->progressionAddTodo(1, $progression_step_name);
        $treatment?->progressionSetCurrentStep( $progression_step_name );

        $dynamicrow->startingFormatting(1);

        $dynamicrow->hasdynamicrow->mergeRawValueFromRow( json_decode($dynamicrow->raw_value) );

        $dynamicvalues = $dynamicrow->dynamicvalues;

        $jobs = [];
        foreach ($dynamicvalues as $dynamicvalue) {
            //$treatment->progressionAddTodo(1, "format value " . $dynamicvalue->id . ", row " . $dynamicvalue->dynamicrow->line_num . "(" . $dynamicvalue->dynamicrow->id . ")" );
            $dynamicvalue->initInnerValue();
            $jobs[] = new DynamicValueFormatJob( $treatment, $dynamicvalue );
        }

        $this->createBatch($treatment, $collectedreportfile, $dynamicrow, $jobs, $progression_step_name);
    }

    private function createBatch(Treatment $treatment, CollectedReportFile $collectedreportfile, DynamicRow $dynamicrow, array $jobs, string $progression_step_name): Batch
    {
        $dynamicrow_id = $dynamicrow->id;
        $collectedreportfile_id = $collectedreportfile->id;
        $treatment_id = $treatment->id;

        $queue_name = self::getQueueCode()->value; //self::getQueueCode()->value . "_" . $this->getNextQueueId();

        $batch = Bus::batch(
            $jobs
        )->then(function (Batch $batch) use ($dynamicrow_id, $treatment_id) {
            // All jobs completed successfully...
            //\Log::info("All jobs completed successfully...");
            //dispatch(new DynamicRowEndImportJob($dynamicrow_id, $end_import_launcher_id, $treatment_id, $batch));
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
            \Log::error("First batch job failure detected...");
        })->finally(function (Batch $batch) use ($treatment_id, $dynamicrow_id, $collectedreportfile_id, $progression_step_name) {
            // The batch has finished executing...
            //\Log::info("The batch has finished executing...");
            \App\Services\Steps\FormatFileStepService::formatRowFinished($treatment_id, $dynamicrow_id, $collectedreportfile_id, $progression_step_name);
        })->onQueue( $queue_name )->name("format row " . $dynamicrow->id . ", file " . $collectedreportfile->local_file_name . " (" . $collectedreportfile->id . ") ")
            ->dispatch();
        //})->onQueue( $queue_name )->name("format row " . $dynamicrow->id . ", file " . $collectedreportfile->local_file_name . " (" . $collectedreportfile->id . ") ")

        //$this->_batch_id = $batch->id;

        return $batch;
    }

    private function getNextQueueId() {
        if ($this->import_queue_id === 0) {
            $this->import_queue_id = 1;
            return $this->import_queue_id;
        }

        $queuecode_value = self::getQueueCode()->value;
        $worker_bounds = Settings::Queues()->workerbounds()->$queuecode_value()->get();
        if ( $this->import_queue_id >= $worker_bounds[1] ) {
            $this->import_queue_id = $worker_bounds[0];
            return $this->import_queue_id;
        }
        $this->import_queue_id += 1;

        return $this->import_queue_id;
    }
    #endregion

    public static function formatRowFinished($treatment_id, $dynamicrow_id, $collectedreportfile_id, $progression_step_name) {
        $dynamicrow = DynamicRow::getById($dynamicrow_id);
        $treatment = \App\Models\Treatments\Treatment::getById($treatment_id)::getById($treatment_id);

        $dynamicrow?->itemFormattingSucceed(1);

        $treatment->progressionAddStepDone($progression_step_name,true, null);

        $collectedreportfile = CollectedReportFile::getById($collectedreportfile_id);

        if ($collectedreportfile?->isFormatted) {
            //$mergefile_count = Treatment::
            //\Log::info("...And the file is imported...");
            if ( ! $collectedreportfile->isMergingReady) {

                $treatment_payloads = ['importTreatmentId' => $treatment_id];
                $treatment?->service->launchNextOnSuccess($treatment_payloads);
                $treatment?->endingWithSuccess();

                $collectedreportfile->setMergingReady();

                //\Log::info("Import finished for collecteddFile " . $collectedreportfile_id . ", Treatment " . $treatment_id . " ended");
            }
        }
    }
}
