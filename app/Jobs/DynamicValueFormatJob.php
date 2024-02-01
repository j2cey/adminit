<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use App\Models\Treatments\Treatment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DynamicValue\DynamicValue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DynamicValueFormatJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $_treatment_id;
    public int $_dynamicvalue_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment, DynamicValue $dynamicvalue)
    {
        $this->_dynamicvalue_id = $dynamicvalue->id;
        $this->_treatment_id = $treatment->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }
        $dynamicvalue = DynamicValue::getById($this->_dynamicvalue_id);

        $dynamicvalue->initFormattedValue();
        $dynamicvalue->load(['htmlformattedvalue','smsformattedvalue']);

        if ( $dynamicvalue->htmlformattedvalue && $dynamicvalue->smsformattedvalue ) {
            //\Log::info("DynamicValueFormatJob - FormattedValue INIT done for DynamicValue " . $dynamicvalue->id);
            $dynamicvalue->applyValueFormat();
        }
    }
}
