<?php

namespace App\Observers;

use App\Models\DynamicValue\DynamicValue;

class DynamicValueObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the DynamicValue "created" event.
     *
     * @param DynamicValue $dynamicvalue
     * @return void
     */
    public function created(DynamicValue $dynamicvalue)
    {
        $dynamicvalue->initFormattedValue();

        if ( $dynamicvalue->htmlformattedvalue && $dynamicvalue->smsformattedvalue ) {
            \Log::info("FormattedValue INIT done for DynamicValue " . $dynamicvalue->id);
            $dynamicvalue->applyValueFormat();

            $new_row_imported = $dynamicvalue->dynamicrow->setValuesImported();
            $dynamicvalue->dynamicrow->hasdynamicrow->setRowsImported($new_row_imported);
        }
    }

    /**
     * Handle the DynamicValue "updated" event.
     *
     * @param DynamicValue $dynamicvalue
     * @return void
     */
    public function updated(DynamicValue $dynamicvalue)
    {
        //
    }

    /**
     * Handle the DynamicValue "deleted" event.
     *
     * @param DynamicValue $dynamicvalue
     * @return void
     */
    public function deleted(DynamicValue $dynamicvalue)
    {
        //
    }

    /**
     * Handle the DynamicValue "restored" event.
     *
     * @param DynamicValue $dynamicvalue
     * @return void
     */
    public function restored(DynamicValue $dynamicvalue)
    {
        //
    }

    /**
     * Handle the DynamicValue "force deleted" event.
     *
     * @param DynamicValue $dynamicvalue
     * @return void
     */
    public function forceDeleted(DynamicValue $dynamicvalue)
    {
        //
    }
}
