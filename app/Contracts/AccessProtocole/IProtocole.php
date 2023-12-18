<?php

namespace App\Contracts\AccessProtocole;

use App\Services\InnerTreatment;
use App\Enums\CriticalityLevelEnum;
use App\Models\Access\AccessAccount;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportTreatments\Treatment;
use Illuminate\Contracts\Filesystem\Filesystem;

interface IProtocole
{
    /**
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticalitylevel
     * @param int $exec_id
     * @param array $treatment_payloads
     * @param AccessAccount $account
     * @param ReportServer $server
     * @param int $port
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param Filesystem|null $disk
     * @return InnerTreatment
     */
    public static function getDisk(Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, array $treatment_payloads, AccessAccount $account, ReportServer $server, int $port, bool $is_last_subtreatment, bool $can_end_uppertreatment, Filesystem|null &$disk): InnerTreatment;
}
