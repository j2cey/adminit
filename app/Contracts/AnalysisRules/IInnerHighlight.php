<?php


namespace App\Contracts\AnalysisRules;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRules\AnalysisHighlight;

interface IInnerHighlight extends Auditable
{
    public static function createNew();
    public static function getList() : array;

    public function analysishighlight();
    public function attachUpperHighlight(AnalysisHighlight $upperhighlight);
}
