<?php

namespace App\Console\Commands\ReportTreatment;

use App\Models\Setting;
use Illuminate\Console\Command;

class ReportTreatmentActivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reporttreatment:activate';

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
        $this->warn("Report Treatments activating...");
        Setting::setReportTreatmentActivate(true);
        $this->info("Report Treatments activated...");
        return 0;
    }
}
