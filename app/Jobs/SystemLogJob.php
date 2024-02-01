<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use App\Models\SystemLog;
use Illuminate\Bus\Queueable;
use App\Models\Jobs\JobLauncher;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SystemLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //private int $_launcher_id;
    private string $logtype;
    private string $message;
    private bool $can_log;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $logtype, string $message, bool $can_log)
    {
        //$launcher = JobLauncher::getLauncher(QueueEnum::SYSTEMLOG);
        //$this->_launcher_id = $launcher->id;
        //$this->onQueue($launcher->queue_name);

        $this->onQueue(QueueEnum::SYSTEMLOG->value);
        $this->logtype = $logtype;
        $this->message = $message;
        $this->can_log = $can_log;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SystemLog::execLog($this->logtype, $this->message, $this->can_log);
        //JobLauncher::getById($this->_launcher_id)?->delete();
    }
}
