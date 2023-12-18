<?php

namespace App\Traits\Time;

use Carbon\Carbon;

trait HasDuration
{
    /**
     * @param Carbon $start_at
     * @param Carbon|null $end_at
     * @return Duration
     */
    public function getNewDuration(Carbon $start_at, Carbon|null $end_at): Duration
    {
        $duration = new Duration($start_at);
        return $duration->end($end_at);
    }
}
