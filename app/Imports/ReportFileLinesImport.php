<?php

namespace App\Imports;

use App\Enums\TreatmentStepCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\ReportFile\CollectedReportFile;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\ReportTreatments\ReportTreatment;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use App\Models\ReportTreatments\ReportTreatmentStep;

class ReportFileLinesImport implements ToModel, WithChunkReading, WithEvents, WithValidation, SkipsOnError
{
    use RemembersRowNumber, Importable, SkipsFailures, SkipsErrors;

    private int $_rownum = 0;
    private int $_totalrows = 0;
    private CollectedReportFile $_collectedreportfile;
    private ReportTreatmentStep $_treatmentstep;

    public function __construct(CollectedReportFile $collectedreportfile, ReportTreatment $reporttreatment, TreatmentStepCode $treatmentstepcode)
    {
        $this->_collectedreportfile = $collectedreportfile;
        $this->_treatmentstep = $reporttreatment->addStep($treatmentstepcode, "Lines Importation for file " . $collectedreportfile->reportfile->name)->startTreatmentStep();
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();

        if ($currentRowNumber == 1) {
            $this->nextRow();
            $this->registerEvents();
            $this->_collectedreportfile->update(['nb_rows' => $this->_totalrows]);

            if ($this->_collectedreportfile->reportfile->has_headers) {
                //$this->_operation_result->endWithSuccess("file has headers.");
                return null;
            }
        }

        if ($currentRowNumber <= $this->_collectedreportfile->row_last_import_processed) {
            $this->nextRow();
            //$this->_operation_result->endWithSuccess("row no " . $currentRowNumber . " already imported.");
            return null;
        }

        if ( $this->_collectedreportfile->imported ) {
            $this->_treatmentstep->endTreatmentWithSuccess("file already imported. " . $this->_collectedreportfile->imported);
            return null;
        }

        $last_inserted_value = null;
        $new_dynamicrow = $this->_collectedreportfile->addRow($row);

        $this->_collectedreportfile->setRowImportSuccess($currentRowNumber);

        $this->nextRow();

        //$this->_operation_result->endWithSuccess();

        return $last_inserted_value;
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
        // Handle the failures how you'd like.
    }

    public function rules(): array
    {
        return [];
    }
}
