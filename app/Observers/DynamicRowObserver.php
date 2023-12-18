<?php

namespace App\Observers;

use App\Enums\QueueEnum;
use Illuminate\Bus\Batch;
use App\Models\Jobs\JobLauncher;
use App\Jobs\DynamicValueFormatJob;
use Illuminate\Support\Facades\Bus;
use App\Jobs\DynamicRowEndImportJob;
use App\Models\DynamicValue\DynamicRow;
use Throwable;

class DynamicRowObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the DynamicRow "created" event.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     * @throws Throwable
     */
    public function created(DynamicRow $dynamicrow)
    {
        //
        //$dynamicrow->raw_value = json_encode($raw_value);
        //$dynamicrow->columns_values = json_encode($raw_value);
        //$dynamicrow->save();

        //$this->mergeRawValueFromRow($raw_value);
        /*
        $dynamicrow->hasdynamicrow->mergeRawValueFromRow( json_decode($dynamicrow->raw_value) );

        //$dynamicrow->setFormattedValue(HtmlTagKey::TABLE_ROW);
        //$dynamicrow->setDefaultFormatSize();

        $hasdynamicattributes = $dynamicrow->getHasdynamicattributes();
        $dynamicrow->addValues($hasdynamicattributes, json_decode($dynamicrow->raw_value));

        $dynamicvalues = $dynamicrow->dynamicvalues;

        $jobs = [];
        foreach ($dynamicvalues as $dynamicvalue) {
            $dynamicvalue->initInnerValue();
            $jobs[] = new DynamicValueFormatJob( $dynamicvalue );
        }

        $launcher_batch = JobLauncher::getLauncher(QueueEnum::FORMATDATA);
        $batch = Bus::batch(
            $jobs
        )->then(function (Batch $batch) {
            // All jobs completed successfully...
            \Log::info("All jobs completed successfully...");
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
            \Log::info("First batch job failure detected...");
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
            \Log::info("The batch has finished executing...");
        })->onQueue($launcher_batch->getQueueName())->name("format row " . $dynamicrow->id . " for ( " . $dynamicrow->hasdynamicrow_type . " -> " . $dynamicrow->hasdynamicrow_id . " )")
            ->dispatch();

        $dynamicrow->initFormattedValue();
        */

        //$dynamicrow->applyFormatFromRaw(null, $dynamicrow->formatrules, true);

        //dispatch(new DynamicRowEndImportJob($dynamicrow->id, JobLauncher::getLauncher(QueueEnum::IMPORTFILE)->id, null, null));
    }

    /**
     * Handle the DynamicRow "updated" event.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function updated(DynamicRow $dynamicrow)
    {
        //
    }

    /**
     * Handle the DynamicRow "deleted" event.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function deleted(DynamicRow $dynamicrow)
    {
        //
    }

    /**
     * Handle the DynamicRow "restored" event.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function restored(DynamicRow $dynamicrow)
    {
        //
    }

    /**
     * Handle the DynamicRow "force deleted" event.
     *
     * @param DynamicRow $dynamicrow
     * @return void
     */
    public function forceDeleted(DynamicRow $dynamicrow)
    {
        //
    }
}
