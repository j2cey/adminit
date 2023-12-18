<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Services\Steps\ImportDataStepService;

class ReportFileDataImportCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfiledata:import {param}';

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
            $index = explode( "_", $param )[3];

            ImportDataStepService::valueAdd($treatment_id, $row_id, $row_number, $index);
        }

        //$this->info("Done. " . $launched_execs . " File(s) imported");

        return 0;
    }
}
