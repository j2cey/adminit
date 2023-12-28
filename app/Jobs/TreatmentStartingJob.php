<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use App\Models\Jobs\JobLauncher;
use App\Services\InnerTreatment;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Treatments\Treatment;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TreatmentStartingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $_launcher_id;

    public int $_treatment_id;

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
    public function __construct(Treatment $treatment, Treatment $childtreatment = null)
    {
        $launcher = JobLauncher::getLauncher(QueueEnum::TREATMENTSTARTEND);
        $this->_launcher_id = $launcher->id;
        $this->onQueue($launcher->queue_name);

        $this->_treatment_id = $treatment->id;
        $this->_childtreatment_id = is_null($childtreatment) ? null : $childtreatment->id;
        /*
        $this->inner_treatment = (new InnerTreatment($treatment, TreatmentCodeEnum::STARTING, CriticalityLevelEnum::MEDIUM, false, false, false, null))->unsetTreatment();
        $this->inner_treatment_key = $this->inner_treatment->getKey();
        \Log::info("TreatmentStartingJob - inner_treatment_key: " . $this->inner_treatment_key);
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

        $treatment->doStarting(Treatment::getById($this->_childtreatment_id));

        JobLauncher::getById($this->_launcher_id)?->delete();
        /*
        $inner_treatment = $this->inner_treatment; //InnerTreatment::getByKey($treatment, $this->inner_treatment_key);
        $inner_treatment->setTreatment($treatment);
        \Log::info("TreatmentStartingJob handled - inner_treatment_key (before succeed): " . $this->inner_treatment_key . " / " . $inner_treatment->getKey());
        $inner_treatment->succeed(null);
        \Log::info("TreatmentStartingJob handled - inner_treatment_key (after succeed): " . $this->inner_treatment_key . " / " . $inner_treatment->getKey());
        */
    }
}
