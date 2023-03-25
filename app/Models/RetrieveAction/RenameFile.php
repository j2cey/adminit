<?php

namespace App\Models\RetrieveAction;

use App\Models\ReportFile\ReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Contracts\RetrieveAction\IRetrieveAction;

class RenameFile implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file): array {
        return [false,"Fonction non implementé"];
    }

}
