<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DynamicValue\DynamicValue;
use App\Models\Treatments\Treatment;
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
        //$this->_launcher_id = $launcher->id;
        //$this->onQueue($launcher->getQueueName());

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
        $treatment = Treatment::getById($this->_treatment_id);
        $dynamicvalue = DynamicValue::getById($this->_dynamicvalue_id);
        $dynamicvalue->startingImport(1, $dynamicvalue->dynamicrow);
        $dynamicvalue->itemImportSucceed(1);

        $dynamicvalue->startingFormatting(1, $dynamicvalue->dynamicrow);
        $dynamicvalue->initFormattedValue();
        $dynamicvalue->load(['htmlformattedvalue','smsformattedvalue']);

        if ( $dynamicvalue->htmlformattedvalue && $dynamicvalue->smsformattedvalue ) {
            //\Log::info("DynamicValueFormatJob - FormattedValue INIT done for DynamicValue " . $dynamicvalue->id);
            $dynamicvalue->applyValueFormat();

            $dynamicvalue->itemFormattingSucceed(1);
        }

        if ($dynamicvalue->dynamicrow->hasdynamicrow->isImportDone) {
            if ($dynamicvalue->dynamicrow->hasdynamicrow->isImported) {
                //\Log::info("importation done for " . get_class($dynamicvalue->dynamicrow->hasdynamicrow) . " (" . $dynamicvalue->dynamicrow->hasdynamicrow->id . ")");
                $treatment->endingWithSuccess();
                //$treatment_payloads = ['collectedReportFileId' => $treatment->service->collectedreportfile->id, 'importTreatmentId' => $treatment->id];
                //$treatment->launchUpperStep(TreatmentCodeEnum::MERGEFILE, $treatment_payloads, true, null);
            } else {
                $treatment->endingWithFailure($dynamicvalue->dynamicrow->hasdynamicrow->importresult->last_failed_message ?? "At least one import failed");
            }
        }
        $treatment->progressionAddStepDone("format value " . $dynamicvalue->id . ", row " . $dynamicvalue->dynamicrow->line_num . "(" . $dynamicvalue->dynamicrow->id . ")",true, null);
    }
}
