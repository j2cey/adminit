<?php

namespace App\Jobs;

use App\Models\SystemLog;
use Illuminate\Bus\Queueable;
use App\Models\Jobs\JobLauncher;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ReportTreatments\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TreatmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public static string $TREATMENTJOB_LOG_INFO_PART = "treatmentjob";

    public int $_launcher_id;

    public int $_treatment_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment)
    {
        $launcher = JobLauncher::getLauncher($treatment->service->queue_code);
        $this->_launcher_id = $launcher->id;
        $this->onQueue($launcher->getQueueName());
        //
        $treatment->queuing();
        $this->_treatment_id = $treatment->id;

        SystemLog::infoTreatments("TreatmentJob __construct - treatment " . $treatment->type->value . ": " . $treatment->name . "(" . $treatment->id . ") - queue_name: " . $launcher->getQueueName(), self::$TREATMENTJOB_LOG_INFO_PART);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $launchedjob = JobLauncher::getById($this->_launcher_id)->addLaunchedJob($this->job->getJobId());

        $treatment = Treatment::getById($this->_treatment_id);
        SystemLog::infoTreatments("TreatmentJob handle - treatment " . $treatment->type->value . ": " . $treatment->name . "(" . $treatment->id . ") - job_launcher: " . $launchedjob->id, self::$TREATMENTJOB_LOG_INFO_PART);
        $treatment->service->exec();

        $launchedjob->delete();
    }

    public function failed(\Exception $e = null)
    {
        Treatment::getById($this->_treatment_id)?->endingWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
    }
}
