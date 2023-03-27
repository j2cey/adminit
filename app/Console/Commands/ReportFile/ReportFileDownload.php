<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Models\ReportFile\ReportFileAccess;

class ReportFileDownload extends Command
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
        \Log::info("Download Fichiers Rapport en cours de traitement...");

        $reportfileaccess = ReportFileAccess::first();
        if( ! is_null($reportfileaccess) ) {
            $result = $reportfileaccess->executeTreatment();
            //dd($result->operationresults,$result->operationresults[0]->isSuccess,$result->operationresults[0]->state);
        }
        $this->info("Traitement termine.");
        \Log::info("Traitement termine.");
        return 0;
    }
}
