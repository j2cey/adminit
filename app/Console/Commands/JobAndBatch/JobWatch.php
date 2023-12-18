<?php

namespace App\Console\Commands\JobAndBatch;

use Illuminate\Console\Command;
use App\Traits\JobAndBatch\JobManagement;

class JobWatch extends Command
{
    use JobManagement;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:watch';

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
        $this->warn("Watch Jobs running...");

        $long_reserved_jobs_reset = $this->longReservedJobsReset();
        $this->info("long reserved jobs reset: " . $long_reserved_jobs_reset);

        $long_pending_queues_reloaded = $this->longPendingQueuesReloadWorkers();
        $this->info("long pending queues reloaded: " . $long_pending_queues_reloaded);

        $this->info("Execution done...");

        return 0;
    }
}
