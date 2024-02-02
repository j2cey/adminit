<?php

namespace App\Contracts\RetrieveAction;

use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Models\ReportFile\ReportFile;
use App\Services\Treatments\InnerTreatment;
use Illuminate\Contracts\Filesystem\Filesystem;

interface IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file, Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment): InnerTreatment;
}
