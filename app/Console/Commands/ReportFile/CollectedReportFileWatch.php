<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Traits\ReportFile\CollectedReportFileArchive;

class CollectedReportFileWatch extends Command
{
    use CollectedReportFileArchive;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collectedreportfile:watch';

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
        $this->warn("Watch CollectedReportFiles running...");

        $expired_values_deleted = $this->expiredValuesDelete();
        $this->info("expired values deleted: " . $expired_values_deleted);

        $expired_rows_deleted = $this->expiredRowsDelete();
        $this->info("expired rows deleted: " . $expired_rows_deleted);

        $expired_collectedreportfiles_delete = $this->expiredCollectedReportFilesDelete();
        $this->info("expired CollectedReportFiles delete: " . $expired_collectedreportfiles_delete);

        $this->info("Execution done...");

        return 0;
    }
}
