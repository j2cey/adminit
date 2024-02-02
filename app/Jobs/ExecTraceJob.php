<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use App\Models\Treatments\Treatment;
use Illuminate\Queue\SerializesModels;
use App\Services\Treatments\ExecTrace;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Enums\Treatments\TreatmentCodeEnum;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExecTraceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //public int $_launcher_id;

    public int $_treatment_id;
    public ?string $_treatmentcode;
    public string $_message;
    public ?string $_description;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment, TreatmentCodeEnum|null $treatmentcode, string $message, string|null $description)
    {
        //$launcher = JobLauncher::getLauncher(QueueEnum::EXECTRACE);
        //$this->_launcher_id = $launcher->id;
        //$this->onQueue($launcher->queue_name);

        $this->onQueue(QueueEnum::EXECTRACE->value);
        $this->_treatment_id = $treatment->id;
        $this->_treatmentcode = $treatmentcode?->value;
        $this->_message = $message;
        $this->_description = $description;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ExecTrace::register( Treatment::getById($this->_treatment_id), ( is_null($this->_treatmentcode) ? null : TreatmentCodeEnum::from($this->_treatmentcode) ), $this->_message, $this->_description );
        //JobLauncher::getById($this->_launcher_id)?->delete();
    }
}
