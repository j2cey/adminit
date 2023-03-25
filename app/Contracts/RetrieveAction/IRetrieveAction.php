<?php

namespace App\Contracts\RetrieveAction;

use App\Models\ReportFile\ReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;

interface IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file): array;
}
