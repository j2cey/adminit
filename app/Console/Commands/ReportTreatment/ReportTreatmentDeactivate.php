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
    protected $signature = 'treatment:deactivate';

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
        $this->warn("Treatments deactivating...");
        Setting::setTreatmentActivate(false);
        $this->info("Treatments deactivated...");
        return 0;
    }
}
