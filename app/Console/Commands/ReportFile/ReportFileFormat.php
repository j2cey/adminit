<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class ReportFileFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:format';

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
        $collectedreportfile = CollectedReportFile::first();
        $treatmentstepresult = ReportTreatmentStepResult::createNew("Formattage des Données du Fichier Charhées dans la BD");
        $collectedreportfile->formatImportedValues($treatmentstepresult);

        return 0;
    }
}
