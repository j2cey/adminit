<?php

namespace App\Console\Commands\JobAndBatch;

use Illuminate\Console\Command;
use App\Traits\JobAndBatch\BatchManagement;

class JobBatchWatch extends Command
{
    use BatchManagement;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobbatch:watch';

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
        $this->warn("Watch Job Batches running...");

        $long_finished_jobbatches_deleted = $this->longFinishedJobBatchesDelete();
        $this->info("long finished job batches deleted: " . $long_finished_jobbatches_deleted);

        $this->info("Execution done...");

        return 0;
    }
}
