<?php

namespace App\Imports;

use Throwable;
use App\Enums\QueueEnum;
use Illuminate\Bus\Batch;
use Maatwebsite\Excel\Row;
use App\Models\Jobs\JobLauncher;
use Illuminate\Support\Facades\Bus;
use App\Jobs\DynamicValueFormatJob;
use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicValue\DynamicRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Events\BeforeImport;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\ReportFile\CollectedReportFile;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

class ReportFileImport implements WithChunkReading, WithEvents, WithValidation, SkipsOnError, OnEachRow
{
    use RemembersRowNumber, Importable, SkipsFailures, SkipsErrors;

    private int $_rownum = 0;
    private int $_totalrows = 0;
    private int $_collectedreportfile_id;
    private int $_treatment_id;

    private string $_batch_id = "";
    private int $end_import_launcher_id = 0;

    public function __construct(CollectedReportFile $collectedreportfile, Treatment $operation)
    {
        $this->_collectedreportfile_id   = $collectedreportfile->id;
        //$this->_step = $step;//->startTreatmentStep();
        $this->_treatment_id = $operation->starting()->id;
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $treatment = Treatment::getById($this->_treatment_id);
        $collectedreportfile = CollectedReportFile::getById($this->_collectedreportfile_id);

        if ($rowIndex == 1) {
            $this->nextRow();
            $this->registerEvents();
            //$collectedreportfile->update(['nb_rows' => $this->_totalrows]);
            $collectedreportfile->startingImport($this->_totalrows - 1, null);
            $collectedreportfile->startingFormatting($this->_totalrows - 1, null);

            if ($collectedreportfile->reportfile->has_headers) {
                return null;
            }
        }

        if ($rowIndex <= $collectedreportfile->importresult->last_import) {
            $this->nextRow();
            return null;
        }

        if ( $collectedreportfile->isImported ) {
            $treatment->endingWithSuccess("file already imported. " . $collectedreportfile->isImported);
            return null;
        }

        //\Log::info("ReportFileImport rowIndex: " . $rowIndex);
        $newrow = $collectedreportfile->addRow($treatment->service->getReportfile()->report, $row);

        $this->formatRowValuesLaunch($treatment, $collectedreportfile, $newrow);

        if ( $rowIndex >= $this->_totalrows ) {
            $treatment_payloads = ['collectedReportFileId' => $collectedreportfile->id, 'importTreatmentId' => $this->_treatment_id];
            $treatment->launchToGivenUpperStep(TreatmentCodeEnum::MERGEFILE, true, true, $treatment_payloads, false);
        }

        /*
        if ( $rowIndex >= $this->_totalrows ) {
            $treatment->launchToGivenUpperStep(TreatmentCodeEnum::IMPORTDATA, true, true, $treatment_payloads, true);
            $treatment->endingWithSuccess();
        }*/
        /*else {
            $treatment->launchToGivenUpperStep(TreatmentCodeEnum::IMPORTDATA, false, false, $treatment_payloads, false);
        }*/
        //event( new AddDynamicRowEvent($this->_operation, $this->_collectedreportfile, $row, ['rowNumber' => $rowIndex]) );
    }


    public function chunkSize(): int
    {
        return 500;
    }

    private function nextRow() {
        //$this->rownum++;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();

                foreach ($totalRows as $row) {
                    $this->_totalrows = $row;
                }
            }
        ];
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        \Log::error( "ReportFileImport Failure: " . json_encode($failures) );
        // Handle the failures how you'd like.
        Treatment::getById($this->_treatment_id)->endingWithFailure( json_encode($failures) );
    }

    public function rules(): array
    {
        return [];
    }


    private function formatRowValuesLaunch(Treatment $treatment, CollectedReportFile $collectedreportfile, DynamicRow $dynamicrow) {
        $dynamicrow->hasdynamicrow->mergeRawValueFromRow( json_decode($dynamicrow->raw_value) );
        $hasdynamicattributes = $dynamicrow->getHasdynamicattributes();
        $dynamicrow->startingImport( count( json_decode($dynamicrow->raw_value) ), $dynamicrow->hasdynamicrow );
        $dynamicrow->startingFormatting( count( json_decode($dynamicrow->raw_value) ), $dynamicrow->hasdynamicrow );
        $dynamicrow->addValues($hasdynamicattributes, json_decode($dynamicrow->raw_value));
        //$dynamicrow->allImportSucceed($collectedreportfile);

        $dynamicvalues = $dynamicrow->dynamicvalues;
        //$dynamicrow->initFormattedValue();

        $jobs = [];
        foreach ($dynamicvalues as $dynamicvalue) {
            $dynamicvalue->initInnerValue();
            $jobs[] = new DynamicValueFormatJob( $treatment, $dynamicvalue );
        }

        $this->createBatch($collectedreportfile, $dynamicrow, $jobs);
        //$this->addToBatch($collectedreportfile, $dynamicrow, $jobs);
    }

    private function addToBatch($collectedreportfile, DynamicRow $dynamicrow, array $jobs) {

        if ( empty($this->_batch_id) ) {
            $this->createBatch($collectedreportfile, $dynamicrow, $jobs);
        }
        $batch = Bus::findBatch($this->_batch_id);
        $batch->add(
            $jobs
        );
    }

    private function createBatch(CollectedReportFile $collectedreportfile, DynamicRow $dynamicrow, array $jobs): Batch
    {
        $dynamicrow_id = $dynamicrow->id;
        $treatment_id = $this->_treatment_id;

        /*if ( empty( $this->end_import_launcher_id ) ) {
            $end_import_launcher_id = JobLauncher::getLauncher(QueueEnum::IMPORTFILE)->id;
        } else {
            JobLauncher::getById( $this->end_import_launcher_id )?->increaseJobsCount();
            $end_import_launcher_id = $this->end_import_launcher_id;
        }*/

        $batch = Bus::batch(
            $jobs
        )->then(function (Batch $batch) use ($dynamicrow_id, $treatment_id) {
            // All jobs completed successfully...
            //\Log::info("All jobs completed successfully...");
            //dispatch(new DynamicRowEndImportJob($dynamicrow_id, $end_import_launcher_id, $treatment_id, $batch));
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
            \Log::error("First batch job failure detected...");
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
            //\Log::info("The batch has finished executing...");
        })->onQueue(JobLauncher::getLauncher(QueueEnum::IMPORTFILE)->getQueueName())->name("format row " . $dynamicrow->id . ", file " . $collectedreportfile->local_file_name . " (" . $collectedreportfile->id . " ) ")
            ->dispatch();

        //$this->_batch_id = $batch->id;

        return $batch;
    }
}
