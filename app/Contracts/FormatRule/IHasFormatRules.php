<?php

namespace App\Contracts\FormatRule;

use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\FormatRule\FormatRuleType;

/**
 * @property FormatRule latestFormatrule
 * @property FormatRule oldestFormatrule
 */
interface IHasFormatRules extends Auditable
{
    public function formatrules();
    public function formatrulesOrdered();

    public function whenallowedformatrules();
    public function whenbrokenformatrules();

    public function latestFormatrule();
    public function oldestFormatrule();

    public function addFormatRule(Model|FormatRuleType $formatruletype, string $title, string $when_rule_result_is, string $description): FormatRule;
    public function addFormatRuleMany(array $attributes);
}
