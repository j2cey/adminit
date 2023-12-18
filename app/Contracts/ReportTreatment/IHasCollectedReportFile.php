<?php

namespace App\Contracts\ReportTreatment;

use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface IHasCollectedReportFile
{
    public function collectedreportfile(): BelongsTo;
    public function setCollectedReportFile(CollectedReportFile|null $collectedreportfile): static;
}
