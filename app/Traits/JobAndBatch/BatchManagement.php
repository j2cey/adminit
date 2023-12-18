<?php

namespace App\Traits\JobAndBatch;

use Illuminate\Support\Facades\DB;
use App\Enums\Settings\ArchiveUnit;
use Illuminate\Database\Query\Builder;

trait BatchManagement
{
    use JobAndBatch;

    private string $JOBBATCHES_TABLE_NAME = "job_batches";
    private string $reserved_at_column = "reserved_at";

    public function longFinishedJobBatchesDelete(): int
    {
        //return $this->longFinishedJobBatches()->delete();
        $long_reserved_ids = $this->longFinishedJobBatches()?->get()->unique('id')->pluck('id');
        $reset_batches = 0;

        if ( ! is_null( $long_reserved_ids ) ) {
            foreach ($long_reserved_ids as $id) {
                DB::table($this->JOBBATCHES_TABLE_NAME)
                    ->where('id', $id)->delete();
                $reset_batches++;
                usleep(2000);
            }
        }

        return $reset_batches;
    }

    private function longFinishedJobBatches(): Builder
    {
        $max_unit = config('Settings.jobbatches.max_finished.unit');
        $max_value = config('Settings.jobbatches.max_finished.value');

        $max_finished_timestamp = $this->getMaxEndTimestamp(ArchiveUnit::from($max_unit), $max_value);
        //\Log::info("max_finished_timestamp: " . $max_finished_timestamp);

        return DB::table( $this->JOBBATCHES_TABLE_NAME )
            ->where('pending_jobs', 0)
            ->where('finished_at', '<', $max_finished_timestamp);
    }
}
