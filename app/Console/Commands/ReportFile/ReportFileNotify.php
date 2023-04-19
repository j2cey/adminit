<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportFile\NotifyReport;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class ReportFileNotify extends Command
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
        \Log::info("Notification Fichiers Rapport en cours de traitement...");

        $collectedreportfile = CollectedReportFile::first();
        $treatmentstepresult = ReportTreatmentStepResult::createNew("Notification du Fichier Rapport");
        $collectedreportfile->notify(report_treatment_step_result: $treatmentstepresult, format_if_any: false);

        \Log::info("Traitement termine.");

        return 0;
    }
}
