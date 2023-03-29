<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use App\Models\DynamicAttributes\DynamicRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\ReportFile\CollectedReportFile;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\ReportTreatments\OperationResult;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class ReportFilesImport implements ToModel, WithChunkReading, WithEvents, WithValidation, SkipsOnError
{
    use RemembersRowNumber, Importable, SkipsFailures, SkipsErrors;

    private int $_rownum = 0;
    private int $_totalrows = 0;
    private CollectedReportFile $_collectedreportfile;
    private ReportTreatmentStepResult $_reporttreatmentstepresult;
    private OperationResult $_operation_result;

    public function __construct(CollectedReportFile $collectedreportfile, ReportTreatmentStepResult $reporttreatmentstepresult)
    {
        $this->_collectedreportfile = $collectedreportfile;
        $this->_reporttreatmentstepresult = $reporttreatmentstepresult;
        $this->_operation_result = $reporttreatmentstepresult->addOperationResult("Exécution du ReportFilesImport");
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        //ICCID,MATCHING_ID,ACTIVATION_CODE CONFIRMATION_CODE (ac)
        //imsi,iccid,pin,puk,eki,pin2,puk2,adm1,opc
        $currentRowNumber = $this->getRowNumber();

        if ($currentRowNumber == 1) {
            $this->nextRow();
            $this->registerEvents();
            $this->_collectedreportfile->update(['nb_rows' => $this->_totalrows]);

            if ($this->_collectedreportfile->reportfile->has_headers) {
                $this->_operation_result->endWithSuccess("file has headers.");
                return null;
            }
        }

        if ($currentRowNumber <= $this->_collectedreportfile->row_last_import_processed) {
            $this->nextRow();
            $this->_operation_result->endWithSuccess("row no " . $currentRowNumber . " already imported.");
            return null;
        }

        if ( $this->_collectedreportfile->imported ) {
            $this->_operation_result->endWithSuccess("file already imported. " . $this->_collectedreportfile->imported);
            return null;
        }

        $last_inserted_value = null;
        $new_dynamicrow = DynamicRow::createNew($this->_collectedreportfile);
        foreach ($this->_collectedreportfile->reportfile->report->dynamicattributesOrdered as $dynamicattribute) {
            $row_index = $dynamicattribute->num_ord - 1;

            $last_inserted_value = $dynamicattribute->addValue($row[$row_index], $new_dynamicrow);
        }

        $this->_collectedreportfile->row_last_import_processed = $currentRowNumber;
        $this->_collectedreportfile->nb_rows_import_processed += 1;
        $this->_collectedreportfile->nb_rows_import_success += 1;

        $this->_collectedreportfile->save();

        //$this->_collectedreportfile->addLineValues($this->_collectedreportfile->latestDynamicrow->columns_values);

        $this->nextRow();

        $this->_operation_result->endWithSuccess();

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
