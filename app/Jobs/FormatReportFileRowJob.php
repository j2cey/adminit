<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use App\Models\DynamicValue\DynamicRow;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class FormatReportFileRowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    private ReportTreatmentStepResult $reporttreatmentstepresult;
    private CollectedReportFile $collectedreportfile;
    private DynamicRow $dynamicrow;
    private ?int $row_index;

    //👇 Making the timeout larger
    //public $timeout = 3600;
    /*private int $stepId;
    private int $collectedreportfileId;
    private int $dynamicrowId;
    private int $treatmentId;*/

    /**
     * Create a new job instance.
     *
     * @return void
     */
    //public function __construct(int $treatmentId, int $stepId, int $collectedreportfileId, int $dynamicrowId, int $row_index = null)
    public function __construct(ReportTreatmentStepResult $reporttreatmentstepresult, CollectedReportFile $collectedreportfile, DynamicRow $dynamicrow, int $row_index = null)
    {
        $this->onQueue(QueueEnum::FORMATFILES->value);
        //
        $reporttreatmentstepresult->reporttreatmentresult->setQueued();
        $this->reporttreatmentstepresult = $reporttreatmentstepresult;
        $this->collectedreportfile = $collectedreportfile;
        $this->dynamicrow = $dynamicrow;
        $this->row_index = $row_index;
        /*ReportTreatmentResult::setReportTreatmentQueued($treatmentId);
        $this->stepId = $stepId;
        $this->collectedreportfileId = $collectedreportfileId;
        $this->dynamicrowId = $dynamicrowId;
        $this->row_index = $row_index;
        $this->treatmentId = $treatmentId;*/
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$dynamicrow = DynamicRow::find($this->dynamicrowId);
        //$dynamicrow->formatDynamicValues(ReportTreatmentStepResult::find($this->stepId), CollectedReportFile::find($this->collectedreportfileId), $this->row_index);

        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }
        $this->dynamicrow->formatDynamicValues($this->reporttreatmentstepresult, $this->collectedreportfile, $this->row_index);
    }

    public function failed(\Throwable $e = null)
    {
        //$this->reporttreatmentstepresult->setFailed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
    }
}
