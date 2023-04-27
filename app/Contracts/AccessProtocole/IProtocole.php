<?php

namespace App\Contracts\AccessProtocole;

use App\Enums\CriticalityLevelEnum;
use App\Models\Access\AccessAccount;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

interface IProtocole
{
    public static function getDisk(ReportTreatmentStepResult $reporttreatmentstepresult, CriticalityLevelEnum $criticalitylevelenum, AccessAccount $account, ReportServer $server, int $port): ?Filesystem;
}
