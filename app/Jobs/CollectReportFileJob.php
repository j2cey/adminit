<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ReportFile\ReportFileAccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Models\ReportTreatments\ReportTreatmentResult;

class CollectReportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ReportTreatmentResult $reporttreatmentresult;
    public ReportFileAccess $reportfileaccess;

    //public $uniqueFor = 3600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ReportTreatmentResult $reporttreatmentresult, ReportFileAccess $reportfileaccess)
    {
        //$this->onQueue(QueueEnum::DOWNLOADFILES->value);
        //
        $reporttreatmentresult->setQueued();
        $this->reporttreatmentresult = $reporttreatmentresult;
        $this->reportfileaccess = $reportfileaccess;
    }

    /*public function middleware() {
        return [ (new WithoutOverlapping( $this->reportfileaccess->id ))->releaseAfter(60) ];
    }*/

    /*public function uniqueId()
    {
        return $this->reporttreatmentresult->id;
    }*/

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->reportfileaccess->executeTreatment($this->reporttreatmentresult);
    }

    public function failed(\Exception $e = null)
    {
        $this->reporttreatmentresult->setFailed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
    }
}
