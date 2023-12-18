<?php

namespace App\Contracts\ReportTreatment;

use App\Models\ReportFile\ReportFile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface IHasReportFile
{
    public function reportfile();
    public function setReportFile(ReportFile|null $reportfile): static;
}
