<?php


namespace App\Contracts\AnalysisRules;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRules\AnalysisRule;

interface IInnerRule extends Auditable
{
    public static function createNew();
    public function ruleFollowed($input) : bool;
    public function ruleBroken($input) : bool;

    public function analysisrule();
    public function attachUpperRule(AnalysisRule $upperrule);
}
