<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Models\ReportFile\ReportFile;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class ReportFileNotifyCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:notify';

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
        $this->info("Notification Fichiers Rapport en cours de traitement...");

        $reportfiles = ReportFile::getActives();
        $launched_execs = 0;

        foreach ($reportfiles as $reportfile) {
            if ( $reportfile->reportTreatmentResultsWaiting()->count() > 0 ) {
                $treatmentresults = $reportfile->reportTreatmentResultsWaiting;

                foreach ($treatmentresults as $treatmentresult) {
                    if ( $treatmentresult->currentstep->code == TreatmentCodeEnum::FORMATDATA && $treatmentresult->currentstep->isSuccess ) {
                        $launched_execs += 1;
                        //$treatmentresult->goToNextStep();
                        $reportfile->notifyLastCollectedFile($treatmentresult, false);
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
