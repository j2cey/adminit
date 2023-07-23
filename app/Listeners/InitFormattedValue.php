<?php

namespace App\Listeners;

use App\Enums\HtmlTagKey;
use App\Events\DynamicValueCreated;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DynamicValue\DynamicValue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InitFormattedValue implements ShouldQueue
{
    use InteractsWithQueue;

    public string $connection = 'database';

    public $queue = 'listeners';

    public $tries = 3;

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
     * @param  \App\Events\DynamicValueCreated  $event
     * @return void
     */
    public function handle(DynamicValueCreated $event)
    {
        // format value
        $dynamicvalue = DynamicValue::getById($event->dynamicvalueId);
        //$this->refresh();
        //$dynamicvalue->refresh();
        $dynamicvalue->applyFormatFromRaw($dynamicvalue->getValue(), $dynamicvalue->getFormatRulesForNotification($dynamicvalue->dynamicrow->hasdynamicrow), false);

        if ($dynamicvalue->dynamicattribute->can_be_notified) {
            $dynamicvalue->dynamicrow->refresh();
            // merge the dynamicvalue's formatted value to the row
            $dynamicvalue->dynamicrow->mergeRawValueFromFormatted($dynamicvalue);
        }
    }
}
