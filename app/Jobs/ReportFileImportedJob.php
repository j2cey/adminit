<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Events\ReportFileImportedEvent;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ReportTreatments\ReportTreatmentResult;

class ReportFileImportedJob implements ShouldQueue
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
        event( new ReportFileImportedEvent( $this->reportfileId, $this->reporttreatmentresultId ) );
    }
}
