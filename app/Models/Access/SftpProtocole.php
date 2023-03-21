<?php

namespace App\Models\Access;

use App\Models\OsAndServer\ReportServer;
use Illuminate\Filesystem\FilesystemManager;
use App\Contracts\AccessProtocole\IProtocole;
use Illuminate\Contracts\Filesystem\Filesystem;

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
