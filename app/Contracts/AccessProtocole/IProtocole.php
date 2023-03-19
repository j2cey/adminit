<?php

namespace App\Contracts\AccessProtocole;

use App\Models\Access\AccessAccount;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Contracts\Filesystem\Filesystem;

interface IProtocole
{
    public static function getDisk(AccessAccount $account, ReportServer $server, int $port): Filesystem;
}
