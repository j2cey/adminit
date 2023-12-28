<?php

namespace App\Console\Commands\ReportFile;

use App\Enums\Settings;
use Illuminate\Console\Command;
use App\Imports\ReportFileImport;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentStateEnum;

class ReportFileImportCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:import {treatmentId=""}';

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
        $this->info("Report File Import running...");
        $treatmentId = (int) $this->argument('treatmentId');
        $launched_execs = 0;

        if ( empty($treatmentId) ) {
            // Launch all
            $this->warn("Launch all, treatmentId: " . $treatmentId);
            $notstarted_treatment = $this->treatmentToImportGet();
            if ( ! is_null($notstarted_treatment) ) {
                $launched_execs+= $this->doImportFile($notstarted_treatment);
                $notstarted_treatment->unpick();
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
    private function treatmentToImportGet(): ?Treatment
    {
        //$max_running = config('Settings.treatment.max_running.importfile_doimport');
        $treatment_code_value = TreatmentCodeEnum::IMPORTFILE_DOIMPORT->value;
        $max_running = Settings::Treatment()->max_running()->$treatment_code_value()->get();

        $notstarted_treatment = Treatment::notStartedGetFirst( TreatmentCodeEnum::IMPORTFILE_DOIMPORT, $max_running );

        if ( empty($notstarted_treatment) ) {
            $this->error("No Not started Treatments !");
            return null;
        }

        $notstarted_treatment->refresh();
        if ( ! $notstarted_treatment->isNotStarted ) {
            $this->error("Treatment NO MORE Not Started !");
            return null;
        }
        return $notstarted_treatment;
    }

    private function doImportFile(Treatment $treatment): int
    {
        $delay = rand(100000,300000);
        usleep($delay);

        if ( $treatment->canBeExecuted ) {
            $treatment->setState(TreatmentStateEnum::PICKING);
            //\Log::info("doImportFile From CMD for treatment: " . $treatment->name . " ( " . $treatment->id . " )");
            if ($treatment->service && $treatment->service->collectedreportfile) {
                (new ReportFileImport($treatment->service->collectedreportfile, $treatment))->import($treatment->service->collectedreportfile->fileLocalAbsolutePath);
                return 1;
            } else {
                $treatment->rewindToPreviousState();
                return 0;
            }
        }

        return 0;
    }
}
