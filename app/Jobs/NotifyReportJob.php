<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Models\ReportTreatments\ReportTreatmentResult;

class NotifyReportJob implements ShouldQueue
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
        //$this->onQueue(QueueEnum::NOTIFYFILES->value);
        //
        $reporttreatmentresult->setQueued();
        $this->reporttreatmentresult = $reporttreatmentresult;
        $this->collectedreportfile = $collectedreportfile;
    }

    /*public function middleware() {
        return [ (new WithoutOverlapping( $this->collectedreportfile->id ))->releaseAfter(60) ];
    }*/

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->collectedreportfile->notify($this->reporttreatmentresult);
    }

    public function failed(\Exception $e = null)
    {
        $this->reporttreatmentresult->setFailed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
    }
}
