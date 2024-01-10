<?php

namespace App\Console\Commands\Treatment;

use Illuminate\Console\Command;
use App\Events\LaunchTreatmentEvent;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentStateEnum;

class TreatmentDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'treatment:dispatch {treatmentId=""}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Treatment Dispatch running...");
        $treatmentId = (int) $this->argument('treatmentId');
        $launched_execs = 0;

        if ( empty($treatmentId) ) {
            // Launch all
            $this->warn("Dispatch all, treatmentId: " . $treatmentId);
            $waiting_treatments = Treatment::getToDispach();
            if ( empty($waiting_treatments) ) {
                $this->error("No Treatments to dispatch !");
            } else {
                foreach ($waiting_treatments as $treatment) {
                    $this->dispatchTreatment($treatment);
                    $launched_execs++;
                }
            }
        } else {
            // Launch one
            $this->warn("Dispatch one, treatmentId: " . $treatmentId);
            $treatment = Treatment::getById($treatmentId);
            //$treatment->service?->dispatch($treatment->service->getReportfile());
            $this->dispatchTreatment($treatment);
            $launched_execs++;
        }

        $this->info("Done. " . $launched_execs . " Treatment(s) dispatched");

        return 0;
    }

    private function dispatchTreatment( Treatment $treatment ) {

        if ( is_null( $treatment->service ) ) {
            \Log::info("dispatchTreatment. No service for treatment: " . $treatment->name . " ( " . $treatment->id . " )");
            return;
        }
        \Log::info("dispatchTreatment. Dispatching DONE for treatment: " . $treatment->name . " ( " . $treatment->id . " )");
        $treatment->setState(TreatmentStateEnum::WAITING);
        $treatment->service->dispatch($treatment->service->getReportfile());
    }
}
