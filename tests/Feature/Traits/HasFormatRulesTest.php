<?php

namespace Tests\Feature\Traits;

use App\Models\FormatRule\FormatRule;
use App\Models\FormatRule\FormatRuleType;
use App\Contracts\FormatRule\IHasFormatRules;

trait HasFormatRulesTest
{
    public abstract function getModel(): IHasFormatRules;

    public function test_aFormatRule_can_be_added_to_the_relevant_model() {
        $model = $this->getModel();

        $formatruletype = FormatRuleType::textColor()->first();
        $model->addFormatRule($formatruletype,"apply red color","broken",null,"");

        // make sure we have a format rule ...
        $this->assertCount(1, FormatRule::all());
        // ... and for this format rule, we have an inner format rule
        $this->assertCount(1, $model->latestFormatrule->innerformatrule()->get());
    }
}
