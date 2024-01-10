<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use App\Models\Jobs\JobLauncher;
use Illuminate\Queue\SerializesModels;
use App\Models\Progression\Progression;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProgressionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $_progression_id;
    public string $_method_name;
    public array $_args;

    public int $_launcher_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Progression $progression, string $method_name, array $args)
    {
        $launcher = JobLauncher::getLauncher(QueueEnum::PROGRESSION);
        $this->_launcher_id = $launcher->id;
        $this->onQueue($launcher->queue_name);

        $this->_progression_id = $progression->id;
        $this->_method_name = $method_name;
        $this->_args = $args;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $progression = Progression::getById($this->_progression_id);
        if ( is_null($progression) ) {
            \Log::error("ProgressionJob - Progression " . $this->_progression_id . " NOT FOUND !");
            return;
        }
        if ( is_callable(array($progression, $this->_method_name)) ) {
            return call_user_func_array(array($progression, $this->_method_name), $this->_args);
        } else {
            \Log::error("ProgressionJob - " . $progression. ", " . $this->_method_name . " is not callable !");
        }

        JobLauncher::getById($this->_launcher_id)?->delete();
    }
}
