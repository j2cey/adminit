<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Services\Steps\ImportDataStepService;

class ReportFileDataRowImportCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfiledatarow:import {param}';

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
        //$this->info("Report File Data Import running...");
        //\Log::info("Report File Data Import running...");
        $param= $this->argument('param');

        if ( empty($treatmentId) ) {
            $this->error("No param provided !");
        } else {
            $treatment_id = explode( "_", $param )[0];
            $row_id = explode( "_", $param )[1];
            $row_number = explode( "_", $param )[2];

            ImportDataStepService::launchValuesAdd($treatment_id, $row_id, $row_number);
        }

        //$this->info("Done. " . $launched_execs . " File(s) imported");

        return 0;
    }

    /**
     * @return Treatment|null
     */
    private function treatmentToImportDataGet(): ?Treatment
    {
        $waiting_treatment = Treatment::pickWaiting( TreatmentCodeEnum::IMPORTDATAROW );
        if ( empty($waiting_treatment) ) {
            $this->error("No Treatments Waiting !");
            return null;
        }
        if ( ! $waiting_treatment->isWaiting ) {
            $this->error("Treatment NO MORE Waiting !");
            return null;
        }
        return $waiting_treatment;
    }
}
