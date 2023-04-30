<?php

namespace App\Console\Commands\Report;

use App\Models\Reports\Report;
use Illuminate\Console\Command;

class ReportExec extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:exec';

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
        $reports = Report::getActives();
        foreach ($reports as $report) {
            $report?->exec();
        }
        return 0;
    }
}
