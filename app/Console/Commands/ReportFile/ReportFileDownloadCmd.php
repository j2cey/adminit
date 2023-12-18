<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Models\ReportFile\ReportFile;

class ReportFileDownloadCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:download';

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
        $this->info("Download Fichiers Rapport en cours de traitement...");

        $reportfiles = ReportFile::getActives();
        $launched_execs = 0;

        foreach ($reportfiles as $reportfile) {
            $this->info("fichier " . $reportfile->id . ", isactive: " . $reportfile->isActive . ", report isactive: " . $reportfile->report->isActive);
            if ( $reportfile->report->isActive && $reportfile->isActive ) {
                if ($reportfile->reportTreatmentsNotCompleted()->count() === 0) {
                    $launched_execs += 1;
                    $reportfile->collectFile(null, true);
                    break;
                }
            }
        }

        $this->info("Traitement termine. " . $launched_execs . " Fichier(s) lancés");
        return 0;
    }
}
