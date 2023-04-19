<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Imports\ReportFilesImport;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class ReportFileImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:import';

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
        \Log::info("Importation Fichiers Rapport en cours de traitement...");

        $file_to_import = CollectedReportFile::first();

        if ( ! is_null($file_to_import) ) {
            $treatmentstepresult = ReportTreatmentStepResult::createNew("Chargement du Fichier Rapport dans la BD");
            $file_to_import->importToDb($treatmentstepresult,true);
        }

        \Log::info("Traitement termine.");

        return 0;
    }
}
