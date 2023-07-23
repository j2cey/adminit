<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\DynamicValue\DynamicRow;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class FormatReportFileRowColumnsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ReportTreatmentResult $reporttreatmentresult;
    private ReportTreatmentStepResult $reporttreatmentstepresult;
    private DynamicRow $dynamicrow;
    private ?int $row_index;
    private CollectedReportFile $collectedreportfile;

    public $uniqueFor = 3600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ReportTreatmentResult $reporttreatmentresult, ReportTreatmentStepResult $reporttreatmentstepresult, CollectedReportFile $collectedreportfile, DynamicRow $dynamicrow, int $row_index = null)
    {
        //
        $reporttreatmentresult->setQueued();
        $this->reporttreatmentresult = $reporttreatmentresult;
        $this->reporttreatmentstepresult = $reporttreatmentstepresult;
        $this->collectedreportfile = $collectedreportfile;
        $this->dynamicrow = $dynamicrow;
        $this->row_index = $row_index;
    }

    public function uniqueId()
    {
        return $this->dynamicrow->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->dynamicrow->mergeColumnsFormattedValues($this->reporttreatmentstepresult, $this->collectedreportfile, $this->row_index);
    }

    public function failed(\Exception $e = null)
    {
        $this->reporttreatmentresult->setFailed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
    }
}
