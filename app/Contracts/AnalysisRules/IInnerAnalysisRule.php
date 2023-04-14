<?php


namespace App\Contracts\AnalysisRules;

use App\Enums\RuleResultEnum;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRule\AnalysisRule;

/**
 * Interface IInnerAnalysisRule
 * représente l'objet final d'analyse
 */
interface IInnerAnalysisRule extends Auditable
{
    public static function createNew();
    public function updateOne(array $attributes = []);

    public function applyRule($input): RuleResultEnum;

    // vérifie si la règle d'analyse est suivi
    public function ruleFollowed($input) : bool;
    // vérifie si la règle d'analyse n'est pas respectée
    public function ruleBroken($input) : bool;

    // retourne le principal object
    public function analysisrule();
    public function attachUpperRule(AnalysisRule $upperrule);
}
