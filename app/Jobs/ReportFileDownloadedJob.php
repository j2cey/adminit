<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ReportFileDownloadedEvent;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\ReportTreatments\ReportTreatmentResult;

class ReportFileDownloadedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $reportfileId;
    private int $reporttreatmentresultId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $reportfileId, ReportTreatmentResult $reporttreatmentresult)
    {
        $reporttreatmentresult->setQueued();
        $this->reportfileId = $reportfileId;
        $this->reporttreatmentresultId = $reporttreatmentresult->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        event( new ReportFileDownloadedEvent( $this->reportfileId, $this->reporttreatmentresultId ) );
    }
}
