<?php

namespace App\Models\Access;

use App\Models\AccessAccount;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Contracts\AccessProtocole\IProtocole;

class SftpProtocole implements IProtocole
{
    public static function getDisk(AccessAccount $account, ReportServer $server, int $port): Filesystem
    {
        $fsMgr = new FilesystemManager(app());

        return $fsMgr->createSftpDriver([
            'host' => $server->ip_address, // required
            'username' => $account->login, // required
            'password' => $account->pwd, // required
            'port' => $port,
        ]);
    }
}
