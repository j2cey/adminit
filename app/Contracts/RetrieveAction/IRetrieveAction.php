<?php

namespace App\Contracts\RetrieveAction;

use App\Enums\CriticalityLevelEnum;
use App\Models\ReportFile\ReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\OperationResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

interface IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file, ReportTreatmentStepResult $reporttreatmentstepresult, CriticalityLevelEnum $criticalitylevelenum, bool $is_last_operation = false): OperationResult;
}
