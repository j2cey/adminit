<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use App\Models\DynamicValue\DynamicRow;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\ReportTreatments\OperationResult;

class FormatDynamicValueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    private int $row_index;
    private int $dynamicvalueId;
    private OperationResult $operation;
    private DynamicRow $dynamicrow;
    private bool $last_treatment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OperationResult $operation, DynamicRow $dynamicrow, int $row_index, int $dynamicvalueId, bool $last_treatment)
    {
        $this->onQueue(QueueEnum::FORMATFILES->value);
        //
        $this->row_index = $row_index;
        $this->operation = $operation;
        $this->dynamicrow = $dynamicrow;
        $this->dynamicvalueId = $dynamicvalueId;
        $this->last_treatment = $last_treatment;
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
        $this->dynamicrow->formatDynamicValue($this->operation, $this->dynamicvalueId,$this->row_index, $this->last_treatment);
    }
}
