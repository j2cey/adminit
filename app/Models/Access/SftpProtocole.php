<?php

namespace App\Models\Access;

use App\Enums\CriticalityLevelEnum;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Filesystem\FilesystemManager;
use App\Contracts\AccessProtocole\IProtocole;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class SftpProtocole implements IProtocole
{
    public static function getDisk(ReportTreatmentStepResult $reporttreatmentstepresult, CriticalityLevelEnum $criticalitylevelenum, AccessAccount $account, ReportServer $server, int $port): ?Filesystem
    {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Récupération Disque/Connexion SFTP", $criticalitylevelenum);
        try {
            $fsMgr = new FilesystemManager(app());

            $disk =  $fsMgr->createSftpDriver([
                'host' => $server->ip_address, // required
                'username' => $account->login, // required
                'password' => $account->pwd, // required
                'port' => $port,
                'timeout' => 10,
            ]);
            $operation_result->endWithSuccess();
            return $disk;
        } catch (\Exception $e) {
            $operation_result->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
            return null;
        }
    }
}
