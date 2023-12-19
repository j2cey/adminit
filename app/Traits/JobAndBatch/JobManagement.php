<?php

namespace App\Traits\JobAndBatch;

use Illuminate\Support\Facades\DB;
use App\Enums\Settings\ArchiveUnit;
use App\Enums\Settings\ArchiveState;
use Illuminate\Database\Query\Builder;

trait JobManagement
{
    use JobAndBatch;

    private string $JOBS_TABLE_NAME = "jobs";
    private string $reserved_at_column = "reserved_at";

    public function longPendingQueuesReloadWorkers(): int
    {
        $long_pending_queues = $this->longPendingJobs()?->get()->unique('queue')->pluck('queue');

        $reloaded_queues = [];

        if ( ! is_null( $long_pending_queues ) ) {
            foreach ($long_pending_queues as $pending_queue) {
                $queue_to_reload = explode("_", $pending_queue)[0];
                //\Log::info("queue_to_reload: " . $queue_to_reload);
                if (!in_array($queue_to_reload, $reloaded_queues)) {
                    $this->reloadWorker($queue_to_reload);
                    $reloaded_queues[] = $queue_to_reload;
                    //\Log::info("queue reloaded !");
                }
            }
        }

        return count($reloaded_queues);
    }

    public function longReservedJobsReset(): int
    {
        $long_reserved_ids = $this->longReservedJobs()?->get()->unique('id')->pluck('id');
        $reset_jobs = 0;

        if ( ! is_null( $long_reserved_ids ) ) {
            foreach ($long_reserved_ids as $id) {
                DB::table($this->JOBS_TABLE_NAME)
                    ->where('id', $id)->update([$this->reserved_at_column => null]);
                $reset_jobs++;
                usleep(2000);
            }
        }

        return $reset_jobs;
        //$upd_rslt = $this->longReservedJobs()?->update([$this->reserved_at_column => null]);
        //return is_null($upd_rslt) ? 0 : $upd_rslt;
    }


    private function longReservedJobs(): ?Builder
    {
        $state = ArchiveState::from( config('Settings.jobs.max_reserved.state') );
        if ( $state === ArchiveState::ENABLED ) {
            $max_unit = config('Settings.jobs.max_reserved.unit');
            $max_value = config('Settings.jobs.max_reserved.value');

            $max_reserved_timestamp = $this->getMaxEndTimestamp(ArchiveUnit::from($max_unit), $max_value);

            //\Log::info("max_reserved_timestamp: " . $max_reserved_timestamp);

            return DB::table($this->JOBS_TABLE_NAME)
                ->whereNotNull($this->reserved_at_column)
                ->where($this->reserved_at_column, '<', $max_reserved_timestamp);
        } else {
            return null;
        }
    }

    private function longPendingJobs(): ?Builder
    {
        $state = ArchiveState::from( config('Settings.jobs.max_pending.state') );
        if ( $state === ArchiveState::ENABLED ) {
            $max_unit = config('Settings.jobs.max_pending.unit');
            $max_value = config('Settings.jobs.max_pending.value');

            $max_pending_timestamp = $this->getMaxEndTimestamp(ArchiveUnit::from($max_unit), $max_value);
            //\Log::info("max_pending_timestamp: " . $max_pending_timestamp);

            return DB::table($this->JOBS_TABLE_NAME)
                ->whereNull($this->reserved_at_column)
                ->where('created_at', '<', $max_pending_timestamp);
        } else {
            return null;
        }
    }
}
