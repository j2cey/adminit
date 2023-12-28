<?php

namespace App\Console\Commands\ReportFile;

use App\Enums\Settings;
use Illuminate\Console\Command;
use App\Imports\ReportFileImport;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentStateEnum;

class ReportFileMergeCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:merge {treatmentId=""}';

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
        $this->info("Report File Merge running...");
        $treatmentId = (int) $this->argument('treatmentId');
        $launched_execs = 0;

        if ( empty($treatmentId) ) {
            // Launch all
            $this->warn("Launch all, treatmentId: " . $treatmentId);
            $treatment_to_merge = $this->treatmentToMergeGet();
            if ( ! is_null($treatment_to_merge) ) {
                $launched_execs+= $this->doImportFile($treatment_to_merge);
                $treatment_to_merge->unpick();
            }
        } else {
            // Launch one
            $this->warn("Launch one, treatmentId: " . $treatmentId);
            $treatment = Treatment::getById($treatmentId);
            $launched_execs+= $this->doImportFile($treatment);
        }

        $this->info("Done. " . $launched_execs . " File(s) imported");

        return 0;
    }

    /**
     * @return Treatment|null
     */
    private function treatmentToMergeGet(): ?Treatment
    {
        $treatment_code_value = TreatmentCodeEnum::MERGEFILE_EXEC->value;
        $max_running = Settings::Treatment()->max_running()->$treatment_code_value()->get();

        $waiting_treatment = Treatment::notstartedOrWaitingGetFirst( TreatmentCodeEnum::MERGEFILE_EXEC, $max_running );
        if ( empty($waiting_treatment) ) {
            $this->error("No Waiting Treatments !");
            return null;
        }

        $waiting_treatment->refresh();
        if ( $waiting_treatment->isNotStarted || $waiting_treatment->isWaiting ) {
            return $waiting_treatment;
        }
        $this->error("Treatment NO MORE Waiting or No more NOT Started !");
        return null;
    }

    private function doImportFile(Treatment $treatment): int
    {
        $delay = rand(100000,300000);
        usleep($delay);

        if ( $treatment->canBeExecuted ) {
            $treatment->setState(TreatmentStateEnum::PICKING);
            //\Log::info("Merge File From CMD for treatment: " . $treatment->name . " ( " . $treatment->id . " )");
            if ( is_null($treatment->service) ) {
                $delay = rand(100000,300000);
                usleep($delay);
                $treatment->rewindToPreviousState();
            } else {
                $treatment->service->exec();
            }
            return 1;
        }

        return 0;
    }
}
