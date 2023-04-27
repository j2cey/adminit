<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\ReportTreatmentResult;

class ImportReportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ReportTreatmentResult $reporttreatmentresult;
    private CollectedReportFile $collectedreportfile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ReportTreatmentResult $reporttreatmentresult, CollectedReportFile $collectedreportfile)
    {
        //
        $reporttreatmentresult->setQueued();
        $this->reporttreatmentresult = $reporttreatmentresult;
        $this->collectedreportfile = $collectedreportfile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->collectedreportfile->importToDb($this->reporttreatmentresult);
    }
}