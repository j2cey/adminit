<?php

namespace App\Traits\ReportTreatment\Administration;

use App\Enums\Settings\ArchiveUnit;
use App\Enums\Settings\ArchiveState;
use App\Traits\Archive\ArchiveDates;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Treatments\Treatment;
use Illuminate\Database\Eloquent\Collection;

trait TreatmentArchive
{
    use ArchiveDates;

    public function expiredTreatmentWithLevelDelete(int $level) {
        //\Log::info("expired Treatments level " . $level . ":");
        $old_treatments = $this->expiredTreatmentWithLevelEqualGet($level);
        $this->deleteOldTreatments($old_treatments);
    }
    public function expiredTreatmentWithLevelGreaterDelete(int $level) {
        //\Log::info("expired Treatments level " . $level . ":");
        $old_treatments = $this->expiredTreatmentWithLevelGreaterGet($level);
        $this->deleteOldTreatments($old_treatments);
    }

    /**
     * @param Treatment[]|null $treatments
     * @return void
     */
    private function deleteOldTreatments($treatments) {
        if ( ! is_null($treatments) ) {
            foreach ($treatments as $treatment) {
                \Log::info($treatment->name . " (" . $treatment->id . ")");
                $treatment->delete();
            }
        }
    }

    /**
     * @param int $level
     * @return Builder[]|Collection|Treatment[]|null
     */
    private function expiredTreatmentWithLevelEqualGet(int $level)
    {
        $state = ArchiveState::from( config('Settings.treatmentarchive.level_' . $level .'.max_before_del.state') );
        if ( $state === ArchiveState::ENABLED ) {
            $max_unit = config('Settings.treatmentarchive.level_' . $level . '.max_before_del.unit');
            $max_value = config('Settings.treatmentarchive.level_' . $level . '.max_before_del.value');
            return $this->levelEqual($this->completeTreatmentExpired(ArchiveUnit::from($max_unit), $max_value), $level)->get();
        } else {
            return null;
        }
    }

    /**
     * @param int $level
     * @return Builder[]|Collection|Treatment[]|null
     */
    private function expiredTreatmentWithLevelGreaterGet(int $level)
    {
        $state = ArchiveState::from( config('Settings.treatmentarchive.level_over_' . $level .'.max_before_del.state') );
        if ( $state === ArchiveState::ENABLED ) {
            $max_unit = config('Settings.treatmentarchive.level_over_' . $level . '.max_before_del.unit');
            $max_value = config('Settings.treatmentarchive.level_over_' . $level . '.max_before_del.value');
            return $this->levelGreater($this->completeTreatmentExpired(ArchiveUnit::from($max_unit), $max_value), $level)->get();
        } else {
            return null;
        }
    }

    private function completeTreatmentExpired(ArchiveUnit $unit, int $max_value): Builder
    {
        $max_end_date = $this->getMaxEndDate($unit, $max_value);
        //\Log::info("Max days: " . $max_days);
        //\Log::info("Max end date: " . $max_end_date);

        return Treatment::completed()
            ->whereDate('end_at', '<', $max_end_date);
    }

    private function levelEqual(Builder $query, int $level): Builder {
        return $query->where('level', $level);
    }
    private function levelLesser(Builder $query, int $level): Builder {
        return $query->where('level', '<', $level);
    }
    private function levelGreater(Builder $query, int $level): Builder {
        return $query->where('level', '>', $level);
    }
}
