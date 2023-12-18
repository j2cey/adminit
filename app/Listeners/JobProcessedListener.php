<?php

namespace App\Listeners;

use App\Models\Jobs\JobLauncher;
use App\Events\JobProcessedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobProcessedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param JobProcessedEvent $event
     * @return void
     */
    public function handle(JobProcessedEvent $event)
    {
        $launchedjob = JobLauncher::getById($event->launcher_id)->addLaunchedJob($event->job_id);
        $launchedjob->delete();
    }
}
