<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Treatments\Treatment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Treatments\InnerTreatment;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Enums\Treatments\TreatmentResultEnum;

class TreatmentEndingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //public int $_launcher_id;

    public int $_treatment_id;
    public string $_treatmentresult;
    public ?string $_message;

    public bool $_is_last_subtreatment;
    public bool $_can_end_uppertreatment;

    public ?int $_childtreatment_id;
    public InnerTreatment $inner_treatment;
    public string $inner_treatment_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment, TreatmentResultEnum $treatmentresult, string|null $message, Treatment $childtreatment = null)
    {
        //$launcher = JobLauncher::getLauncher(QueueEnum::TREATMENTSTARTEND);
        //$this->_launcher_id = $launcher->id;
        //$this->onQueue($launcher->queue_name);

        $this->_treatment_id = $treatment->id;
        $this->_treatmentresult = $treatmentresult->value;
        $this->_message = $message;
        $this->_childtreatment_id = is_null($childtreatment) ? null : $childtreatment->id;
        /*
        $this->inner_treatment = (new InnerTreatment($treatment, TreatmentCodeEnum::ENDING, CriticalityLevelEnum::MEDIUM, false, false, false, null))->unsetTreatment();
        $this->inner_treatment_key = $this->inner_treatment->getKey();
        */
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $treatment = Treatment::getById($this->_treatment_id);
        $treatmentresult = TreatmentResultEnum::from($this->_treatmentresult);

        $treatment->doEnding($treatmentresult, $this->_message, Treatment::getById($this->_childtreatment_id));

        //JobLauncher::getById($this->_launcher_id)?->delete();
        /*
        $inner_treatment = $this->inner_treatment;
        $inner_treatment->setTreatment($treatment);
        $inner_treatment->succeed(null);
        */
    }
}
