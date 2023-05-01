<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Models\ReportFile\ReportFile;

class ReportFileActivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:activate {reportfileId}';

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
        $reportfileId = $this->argument('reportfileId');
        if ($reportfileId) {
            $report = ReportFile::getById($reportfileId);
            if ($report) {
                $report->activate();
                $this->info('Fichier de Rapport active avec succes!');
            } else {
                $this->error('Fichier de Rapport non non trouve !');
            }
        } else {
            $this->error('ID du Fichier de Rapport non fourni !');
        }
        return 0;
    }
}
