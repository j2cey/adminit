<?php


namespace App\Contracts\AnalysisRules;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRules\AnalysisRule;

/**
 * Interface IInnerRule
 * représente l'objet final d'analyse
 */
interface IInnerRule extends Auditable
{
    public static function createNew();
    // vérifie si la règle d'analyse est suivi
    public function ruleFollowed($input) : bool;
    // vérifie si la règle d'analyse n'est pas respectée
    public function ruleBroken($input) : bool;

    // retourne le principal object
    public function analysisrule();
    public function attachUpperRule(AnalysisRule $upperrule);
}
