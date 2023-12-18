<?php

namespace App\Listeners;

use App\Enums\QueueEnum;
use App\Enums\HtmlTagKey;
use App\Models\Jobs\JobLauncher;
use App\Events\JobProcessedEvent;
use App\Events\DynamicValueCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DynamicValue\DynamicValue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InitFormattedValueListener
{
    /*use InteractsWithQueue;

    public string $connection = 'database';
    public ?int $launcher_id = null;
    */

    //public $queue = 'listeners';

    //public $tries = 3;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /*public function viaQueue(): string
    {
        $launcher = JobLauncher::getLauncher(QueueEnum::LISTENERS);
        $this->launcher_id = $launcher->id;
        return $launcher->getQueueName();//self::setQueueName(QueueEnum::LISTENERS);
    }*/

    /**
     * Handle the event.
     *
     * @param  \App\Events\DynamicValueCreatedEvent  $event
     * @return void
     */
    public function handle(DynamicValueCreatedEvent $event)
    {
        // format value
        //$dynamicvalue = DynamicValue::getById($event->dynamicvalueId);
        //$this->refresh();

        //$dynamicvalue->initFormattedValue();
        //event( new JobProcessedEvent($this->job->getJobId(), $this->launcher_id));
    }
}
