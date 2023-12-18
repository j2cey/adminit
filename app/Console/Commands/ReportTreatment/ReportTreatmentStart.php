<?php

namespace App\Console\Commands\ReportTreatment;

use Illuminate\Console\Command;
use App\Models\ReportFile\ReportFile;

class ReportTreatmentStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'treatment:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start all report treatments ready';

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
        $this->info("Demarrage Traitement Fichiers Rapport en cours de traitement...");

        $reportfiles = ReportFile::getActives();
        $launched_execs = 0;

        foreach ($reportfiles as $reportfile) {
            if ( $reportfile->report->isActive && $reportfile->isActive ) {
                if ($reportfile->reportTreatmentResultsNotCompleted()->count() === 0) {
                    $launched_execs += 1;
                    $reportfile->collectFile(null, false);
                    break;
                }
            }
        }

        $this->info("Traitement termine. " . $launched_execs . " Fichier(s) lancés");
        return 0;
    }
}
