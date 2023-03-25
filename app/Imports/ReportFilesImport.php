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
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\ReportFile\CollectedReportFile;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class ReportFilesImport implements ToModel, WithChunkReading, WithEvents, WithValidation, SkipsOnError
{
    use RemembersRowNumber, Importable, SkipsFailures, SkipsErrors;

    private int $_rownum = 0;
    private int $_totalrows = 0;
    private CollectedReportFile $_collectedreportfile;
    private ReportTreatmentStepResult $_reporttreatmentstepresult;

    public function __construct(CollectedReportFile $collectedreportfile, ReportTreatmentStepResult $reporttreatmentstepresult)
    {
        $this->_collectedreportfile = $collectedreportfile;
        $this->_reporttreatmentstepresult = $reporttreatmentstepresult;
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
            return null;
        }

        if ($currentRowNumber < $this->_collectedreportfile->row_last_import_processed) {
            $this->nextRow();
            return null;
        }

        $last_inserted_value = null;
        foreach ($this->_collectedreportfile->reportfile->report->dynamicattributes as $dynamicattribute) {
            $row_index = $dynamicattribute->num_ord - 1;
            $new_row = ($row_index === 0);
            $last_inserted_value = $dynamicattribute->addValue($row[$row_index], $new_row);
        }

        $this->_collectedreportfile->row_last_import_processed = $currentRowNumber;

        $this->_collectedreportfile->save();

        $this->nextRow();

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