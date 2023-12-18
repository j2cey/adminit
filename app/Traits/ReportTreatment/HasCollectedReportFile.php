<?php

namespace App\Traits\ReportTreatment;

use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $collected_report_file_id
 *
 * @property CollectedReportFile $collectedreportfile
 */
trait HasCollectedReportFile
{
    public function collectedreportfile(): BelongsTo
    {
        return $this->belongsTo(CollectedReportFile::class, 'collected_report_file_id');
    }

    public function setCollectedReportFile(CollectedReportFile|null $collectedreportfile): static
    {
        if ( ! is_null($collectedreportfile) ) {
            $this->collectedreportfile()->associate($collectedreportfile);
            $this->save();
        }

        return $this;
    }

    protected function initializeHasCollectedReportFile()
    {
        $this->with = array_unique(array_merge($this->with, ['collectedreportfile']));
    }
}
