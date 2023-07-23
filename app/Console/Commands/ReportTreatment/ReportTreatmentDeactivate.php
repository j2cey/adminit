<?php

namespace App\Console\Commands\ReportTreatment;

use App\Models\Setting;
use Illuminate\Console\Command;

class ReportTreatmentDeactivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reporttreatment:deactivate';

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
        $this->warn("Report Treatments deactivating...");
        Setting::setReportTreatmentActivate(false);
        $this->info("Report Treatments deactivated...");
        return 0;
    }
}
