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
use App\Models\ReportTreatments\ReportTreatment;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Models\ReportTreatments\ReportTreatmentResult;

class NotifyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ReportTreatment $reporttreatment;
    private CollectedReportFile $collectedreportfile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ReportTreatment $reporttreatment, CollectedReportFile $collectedreportfile)
    {
        //$this->onQueue(QueueEnum::NOTIFYFILES->value);
        //
        $reporttreatment->setQueued();
        $this->reporttreatment = $reporttreatment;
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
        $this->collectedreportfile->notify($this->reporttreatment);
    }

    public function failed(\Exception $e = null)
    {
        $this->reporttreatment->setFailed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
    }
}
