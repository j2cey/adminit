<?php

namespace App\Contracts\RetrieveAction;

use App\Models\ReportFile\ReportFile;

interface IRetrieveAction
{
    public static function execRetrieveAction(ReportFile $file);
}
