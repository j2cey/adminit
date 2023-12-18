<?php

namespace App\Listeners;

use App\Enums\HtmlTagKey;
use App\Helpers\SymphonyProcess;
use App\Events\DynamicValueCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DynamicValue\DynamicValue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetInnerValueListener
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
     * @param DynamicValueCreatedEvent $event
     * @return void
     */
    public function handle(DynamicValueCreatedEvent $event)
    {
        $dynamicvalue = DynamicValue::getById($event->dynamicvalueId);
        $dynamicvalue->dynamicattribute->dynamicattributetype->model_type::createFromDynamicValue($dynamicvalue);

        $dynamicvalue->refresh();

        //SymphonyProcess::runBackgroundProcess("valueformat:init", $dynamicvalue->id);
    }
}
