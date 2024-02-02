<?php

namespace App\Models\Access;

use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Models\OsAndServer\ReportServer;
use App\Services\Treatments\InnerTreatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use Illuminate\Filesystem\FilesystemManager;
use App\Contracts\AccessProtocole\IProtocole;
use Illuminate\Contracts\Filesystem\Filesystem;

class SftpProtocole implements IProtocole
{
    public static function getDisk(Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, array $treatment_payloads, AccessAccount $account, ReportServer $server, int $port, bool $is_last_subtreatment, bool $can_end_uppertreatment, Filesystem|null &$disk): InnerTreatment
    {

        //$treatment_operation = $treatment->operationAddOrGet(TreatmentCodeEnum::PROTOCOL_DISK_GET, $criticalitylevel, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, false, false, array_merge($treatment_payloads, ["protocol"=>"SFTP"]), null)
        //    ->starting();
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::PROTOCOL_DISK_GET, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, "SFTP");
        try {
            $fsMgr = new FilesystemManager(app());

            $disk =  $fsMgr->createSftpDriver([
                'host' => $server->ip_address, // required
                'username' => $account->login, // required
                'password' => $account->pwd, // required
                'port' => $port,
                'timeout' => 10,
            ]);
            return $innertreatment->succeed(null);
        } catch (\Exception $e) {
            return $innertreatment->failed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }
}
