<?php

namespace App\Traits\FormatRule;

use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormatRule\FormatRuleType;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property FormatRule[] $whenallowedformatrules
 * @property FormatRule[] $whenbrokenformatrules
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
     * Get all of the model's dynamic attributes ordered
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
            ->where("when_rule_result_is", 'allowed');
    }

    /**
     * @return MorphMany
     * List of MorphMany to apply when this rule is broken
     */
    public function whenbrokenformatrules() {
        return $this->formatrules()
            ->where("when_rule_result_is", 'broken');
    }


    /**
     * Get the lastets of the model's dynamic attributes
     * @return mixed
     */
    public function latestFormatrule()
    {
        return $this->morphOne(FormatRule::class, 'hasformatrule')->latest('id');
    }

    /**
     * Get the oldest of the model's dynamic attributes
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
     * @param string $when_rule_result_is
     * @param string|null $description
     * @return FormatRule
     */
    public function addFormatRule(Model|FormatRuleType $formatruletype, string $title, string $when_rule_result_is, string $description = null): FormatRule
    {
        $num_ord = $this->formatrules()->count() + 1;         // set the format rule number order
        $formatrule = FormatRule::createNew(
            $formatruletype,
            $title,
            $when_rule_result_is,
            $description,
            $num_ord
        );                                                  // create new FormatRule + InnerFormatRule
        $this->formatrules()->save($formatrule);            // attach the new FormatRule to the current model object

        $formatrule->save();                                // save the association from the FormatRule

        return $formatrule;
    }

    /**
     * Add Many DynamicAttribute at once
     * @param array $attributes Attributes array: [['formatruletype' => FormatRuleType, 'title' => "title", 'when_rule_result_is' => "when_rule_result_is", 'description' => "description"]]
     * @return int
     */
    public function addFormatRuleMany(array $attributes) {
        $nb_created = 0;

        foreach ($attributes as $attribute) {
            $this->addFormatRule($attribute['formatruletype'], $attribute['title'], $attribute['when_rule_result_is'], $attribute['description']);
        }

        return $nb_created;
    }

    #endregion

    protected function initializeHasFormatRules()
    {
        $this->with = array_unique(array_merge($this->with, ['formatrules']));
    }
}
