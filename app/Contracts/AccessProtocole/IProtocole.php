<?php

namespace App\Contracts\AccessProtocole;

use App\Enums\CriticalityLevelEnum;
use App\Models\Access\AccessAccount;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\ReportTreatmentStep;

interface IProtocole
{
    public static function getDisk(ReportTreatmentStep $reporttreatmentstep, CriticalityLevelEnum $criticalitylevelenum, AccessAccount $account, ReportServer $server, int $port): ?Filesystem;
}
