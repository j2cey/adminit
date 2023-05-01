<?php

namespace App\Console\Commands\Report;

use App\Models\Reports\Report;
use Illuminate\Console\Command;

class ReportActivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:activate {reportId}';

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
        $reportId = $this->argument('reportId');
        if ($reportId) {
            $report = Report::getById($reportId);
            if ($report) {
                $report->activate();
                $this->info('Rapport active avec succes!');
            } else {
                $this->error('Rapport non non trouve !');
            }
        } else {
            $this->error('ID du Rapport non fourni !');
        }
        return 0;
    }
}
