<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Enums\TreatmentStepCode;
use App\Models\ReportFile\ReportFile;
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
        $this->info("Formattage Fichiers Rapport en cours de traitement...");

        $reportfiles = ReportFile::getActives();
        $launched_execs = 0;

        foreach ($reportfiles as $reportfile) {
            if ( $reportfile->reportTreatmentResultsWaiting()->count() > 0 ) {
                $reporttreatmentresults = $reportfile->reportTreatmentResultsWaiting;

                foreach ($reporttreatmentresults as $reporttreatmentresult) {
                    if ( $reporttreatmentresult->currentstep->code == TreatmentStepCode::IMPORTFILE && $reporttreatmentresult->currentstep->isSuccess ) {
                        $launched_execs += 1;
                        //$reporttreatmentresult->goToNextStep();
                        $reportfile->formatLastCollectedFile($reporttreatmentresult, false);
                        break;
                    }
                }
                if ($launched_execs > 0) {
                    break;
                }
            }
        }

        $this->info("Traitement termine. " . $launched_execs . " Fichier(s) lancés");

        return 0;
    }
}
