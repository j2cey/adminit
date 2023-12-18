<?php

namespace App\Traits\ReportTreatment;

use App\Models\SystemLog;
use App\Models\ReportFile\ReportFile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $report_file_id
 *
 * @property ReportFile $reportfile
 */
trait HasReportFile
{
    /**
     * @return BelongsTo
     */
    public function reportfile()
    {
        return $this->belongsTo(ReportFile::class, 'report_file_id');
    }

    public function setReportFile(ReportFile|null $reportfile): static
    {
        /*$result = $this->update([
            'report_file_id' => $reportfile->id
        ]);*/

        //$result = $this->reportfile()->associate( $reportfile );
        if ( ! is_null( $reportfile ) ) {
            //$result = $this->reportfile()->associate($reportfile);//->save();

            $result = $this->update([
                'report_file_id' => $reportfile->id,
            ]);

            SystemLog::infoTreatments("HasReportFile for " . get_class($this) . "(" . $this->id . ") - setReportFile, reportfile: " . $reportfile->id . ", update result: " . $result, ReportFile::$REPORTFILE_TREATMENT_LOG_INFO_PART);

            //$this->load('reportfile');
        } else {
            SystemLog::infoTreatments("HasReportFile - setReportFile, reportfile is NULL", ReportFile::$REPORTFILE_TREATMENT_LOG_INFO_PART);
        }

        return $this;
    }

    protected function initializeHasReportFile()
    {
        $this->with = array_unique(array_merge($this->with, ['reportfile']));
    }
}
