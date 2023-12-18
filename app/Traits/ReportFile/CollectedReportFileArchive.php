<?php

namespace App\Traits\ReportFile;

use App\Enums\Settings\ArchiveUnit;
use App\Traits\Archive\ArchiveDates;
use App\Enums\Settings\ArchiveState;
use App\Models\DynamicValue\DynamicRow;
use Illuminate\Database\Eloquent\Builder;
use App\Models\DynamicValue\DynamicValue;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ReportFile\CollectedReportFile;

trait CollectedReportFileArchive
{
    use ArchiveDates;

    public function expiredValuesDelete(): int
    {
        $old_values = $this->expiredValuesGet();
        $deleted_count = 0;
        if ( ! is_null($old_values) ) {
            foreach ($old_values as $old_value) {
                \Log::info($old_value->raw_value . " (" . $old_value->id . ")");
                $old_value->delete();
                $deleted_count++;
            }
        }
        return $deleted_count;
    }
    public function expiredRowsDelete(): int
    {
        $deleted_count = 0;
        $old_rows = $this->expiredRowsGet();
        if ( ! is_null($old_rows) ) {
            foreach ($old_rows as $old_row) {
                \Log::info($old_row->raw_value . " (" . $old_row->id . ")");
                $old_row->delete();
                $deleted_count++;
            }
        }
        return $deleted_count;
    }
    public function expiredCollectedReportFilesDelete(): int
    {
        $deleted_count = 0;
        $old_collectedreportfiles = $this->expiredCollectedReportFilesGet();
        if ( ! is_null($old_collectedreportfiles) ) {
            foreach ($old_collectedreportfiles as $old_collectedreportfile) {
                \Log::info($old_collectedreportfile->raw_value . " (" . $old_collectedreportfile->id . ")");
                $old_collectedreportfile->delete();
                $deleted_count++;
            }
        }
        return $deleted_count;
    }

    /**
     * @return DynamicValue[]|Builder[]|Collection|null[]|null
     */
    private function expiredValuesGet() {
        return $this->expiredValues()?->get();
    }

    /**
     * @return DynamicRow[]|Builder[]|Collection|null[]|null
     */
    private function expiredRowsGet() {
        return $this->expiredRows()?->get();
    }

    /**
     * @return CollectedReportFile[]|Builder[]|Collection|null[]|null
     */
    private function expiredCollectedReportFilesGet() {
        return $this->expiredCollectedReportFiles()?->get();
    }

    private function expiredValues(): ?Builder
    {
        $state = ArchiveState::from( config('Settings.collectedreportfile.delete_expired.values.state') );
        if ( $state === ArchiveState::ENABLED ) {
            $max_unit = ArchiveUnit::from( config('Settings.collectedreportfile.delete_expired.values.unit') );
            $max_value = config('Settings.collectedreportfile.delete_expired.values.value');

            $max_end_date = $this->getMaxEndDate($max_unit, $max_value);

            //\Log::info("CollectedReportFile::class: " . CollectedReportFile::class);

            return DynamicRow::formatted()->where('hasdynamicattributes_class', CollectedReportFile::class)
                ->whereHas('dynamicvalues', function (Builder $q) use ($max_end_date){
                $q->whereDate('created_at', '<', $max_end_date);
                }
            );
        } else {
            return null;
        }
    }

    private function expiredRows(): ?Builder
    {
        $state = ArchiveState::from( config('Settings.collectedreportfile.delete_expired.rows.state') );
        if ( $state === ArchiveState::ENABLED ) {
            $max_unit = ArchiveUnit::from( config('Settings.collectedreportfile.delete_expired.rows.unit') );
            $max_value = config('Settings.collectedreportfile.delete_expired.rows.value');

            $max_end_date = $this->getMaxEndDate($max_unit, $max_value);

            //\Log::info("CollectedReportFile::class: " . CollectedReportFile::class);

            return CollectedReportFile::treated()
                ->whereHas('dynamicrows', function (Builder $q) use ($max_end_date){
                $q->whereDate('created_at', '<', $max_end_date);
                }
            );
        } else {
            return null;
        }
    }

    private function expiredCollectedReportFiles(): ?Builder
    {
        $state = ArchiveState::from( config('Settings.collectedreportfile.delete_expired.state') );
        if ( $state === ArchiveState::ENABLED ) {
            $max_unit = ArchiveUnit::from( config('Settings.collectedreportfile.delete_expired.unit') );
            $max_value = config('Settings.collectedreportfile.delete_expired.value');

            $max_end_date = $this->getMaxEndDate($max_unit, $max_value);

            //\Log::info("CollectedReportFile::class: " . CollectedReportFile::class);

            return CollectedReportFile::treated()->whereDate('created_at', '<', $max_end_date);
        } else {
            return null;
        }
    }
}
