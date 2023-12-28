<?php

namespace App\Jobs;

use App\Models\SystemLog;
use Illuminate\Bus\Queueable;
use App\Models\Jobs\JobLauncher;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Treatments\Treatment;
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
        $this->onQueue($launcher->queue_name);
        //
        $treatment->queuing();
        $this->_treatment_id = $treatment->id;

        SystemLog::infoTreatments("TreatmentJob __construct - treatment " . $treatment->type->value . ": " . $treatment->name . "(" . $treatment->id . ") - queue_name: " . $launcher->queue_name, self::$TREATMENTJOB_LOG_INFO_PART);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $treatment = Treatment::getById($this->_treatment_id);
        SystemLog::infoTreatments("TreatmentJob handle - treatment " . $treatment->type->value . ": " . $treatment->name . "(" . $treatment->id . ") - job_launcher: " . $this->_launcher_id, self::$TREATMENTJOB_LOG_INFO_PART);
        $treatment->service->exec();

        JobLauncher::getById($this->_launcher_id)?->delete();
    }

    public function failed(\Exception $e = null)
    {
        Treatment::getById($this->_treatment_id)?->endingWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
    }
}
