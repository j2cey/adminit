<?php

namespace App\Traits\FormatRule;

use App\Models\Status;
use App\Enums\RuleResultEnum;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormatRule\FormatRuleType;
use App\Contracts\FormatRule\IInnerFormatRule;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property FormatRule[] $whenallowedformatrules
 * @property FormatRule[] $whenbrokenformatrules
 * @property FormatRule[] $formatrules
 */
trait HasFormatRules
{
    /**
     * Get all of the model's format rules
     * @return MorphMany
     */
    public function formatrules()
    {
        return $this->morphMany(FormatRule::class, 'hasformatrule');
    }
    /**
     * Get all of the model's dynamic dynamicattributes ordered
     * @return mixed
     */
    public function formatrulesOrdered()
    {
        return $this->formatrules()
            ->orderBy('id');
    }

    /**
     * @return MorphMany
     * List of FormatRules to apply when this rule is allowed
     */
    public function whenallowedformatrules() {
        return $this->formatrules()
            ->where("rule_result", RuleResultEnum::ALLOWED->value);
    }

    /**
     * @return MorphMany
     * List of MorphMany to apply when this rule is broken
     */
    public function whenbrokenformatrules() {
        return $this->formatrules()
            ->where("rule_result", RuleResultEnum::BROKEN->value);
    }


    /**
     * Get the lastets of the model's dynamic dynamicattributes
     * @return mixed
     */
    public function latestFormatrule()
    {
        return $this->morphOne(FormatRule::class, 'hasformatrule')->latest('id');
    }

    /**
     * Get the oldest of the model's dynamic dynamicattributes
     * @return mixed
     */
    public function oldestFormatrule()
    {
        return $this->morphOne(FormatRule::class, 'hasformatrule')->oldest('id');
    }

    #region Custom Functions

    /**
     * @param Model|FormatRuleType $formatruletype
     * @param string $title
     * @param IInnerFormatRule|string|null $innerformatrule
     * @param string|null $rule_result
     * @param Status|null $status
     * @param string|null $description
     * @return FormatRule
     */
    public function addFormatRule(Model|FormatRuleType $formatruletype, string $title, IInnerFormatRule|string $innerformatrule = null, string $rule_result = null, Status $status = null, string $description = null): FormatRule
    {
        $num_ord = $this->formatrules()->count() + 1;       // set the format rule number order
        $formatrule = FormatRule::createNew(
            $formatruletype,
            $title,
            $innerformatrule,
            $rule_result,
            $status,
            $description,
            $num_ord
        );                                                  // create new FormatRule + InnerFormatRule
        $this->formatrules()->save($formatrule);            // attach the new FormatRule to the current model object

        $formatrule->save();                                // save the association from the FormatRule

        return $formatrule;
    }

    /**
     * Add Many DynamicAttribute at once
     * @param array $attributes Attributes array: [['formatruletype' => FormatRuleType, 'title' => "title", 'rule_result' => "when_rule_result_is", 'description' => "description"]]
     * @return int
     */
    public function addFormatRuleMany(array $attributes) {
        $nb_created = 0;

        foreach ($attributes as $attribute) {
            $this->addFormatRule(
                $attribute['formatruletype'],
                $attribute['title'],
                $attribute['rule_result'],
                $attribute['status'] ?? null,
                $attribute['description'] ?? null
            );
        }

        return $nb_created;
    }

    public function setDefaultFormatSize() {
        $this->addFormatRule(FormatRuleType::textSize()->first(),"default text size")->innerformatrule->update([
            'format_value' => 10,
            'comment' => "default text size from system",
        ]);
    }

    #endregion

    protected function initializeHasFormatRules()
    {
        $this->with = array_unique(array_merge($this->with, ['formatrules']));
    }
}
