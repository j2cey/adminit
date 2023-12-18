<?php

namespace App\Observers;

use App\Models\ReportFile\CollectedReportFile;

class CollectedReportFileObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the CollectedReportFile "created" event.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return void
     */
    public function created(CollectedReportFile $collectedreportfile)
    {
        $collectedreportfile->initFormattedValue();
    }

    /**
     * Handle the CollectedReportFile "updated" event.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return void
     */
    public function updated(CollectedReportFile $collectedreportfile)
    {
        //
    }

    /**
     * Handle the CollectedReportFile "deleted" event.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return void
     */
    public function deleted(CollectedReportFile $collectedreportfile)
    {
        //
    }

    /**
     * Handle the CollectedReportFile "restored" event.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return void
     */
    public function restored(CollectedReportFile $collectedreportfile)
    {
        //
    }

    /**
     * Handle the CollectedReportFile "force deleted" event.
     *
     * @param CollectedReportFile $collectedreportfile
     * @return void
     */
    public function forceDeleted(CollectedReportFile $collectedreportfile)
    {
        //
    }
}
