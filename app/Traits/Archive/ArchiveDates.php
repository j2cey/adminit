<?php

namespace App\Traits\Archive;

use Illuminate\Support\Carbon;
use App\Enums\Settings\ArchiveUnit;

trait ArchiveDates
{
    public function getMaxEndDate(ArchiveUnit $unit, int $max_value): string
    {
        return match ($unit) {
            ArchiveUnit::SECOND => Carbon::now()->subSeconds($max_value)->format("Y-m-d H:i:s"),
            ArchiveUnit::MINUTE => Carbon::now()->subMinutes($max_value)->format("Y-m-d H:i:s"),
            ArchiveUnit::HOUR => Carbon::now()->subHours($max_value)->format("Y-m-d H:i:s"),
            ArchiveUnit::DAY => Carbon::now()->subDays($max_value)->format("Y-m-d H:i:s"),
            default => null,
        };
    }

    public function getMaxEndTimestamp(ArchiveUnit $unit, int $max_value): float|int|string
    {
        return match ($unit) {
            ArchiveUnit::SECOND => Carbon::now()->subSeconds($max_value)->timestamp,
            ArchiveUnit::MINUTE => Carbon::now()->subMinutes($max_value)->timestamp,
            ArchiveUnit::HOUR => Carbon::now()->subHours($max_value)->timestamp,
            ArchiveUnit::DAY => Carbon::now()->subDays($max_value)->timestamp,
            default => null,
        };
    }
}
