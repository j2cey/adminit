<?php

namespace App\Traits\AnalysisRules;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnalysisRule\AnalysisRule;
use App\Models\AnalysisRule\AnalysisRuleType;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAnalysisRules
{
    /**
     * Get all of the model's format rules
     * @return MorphMany
     */
    public function analysisrules()
    {
        return $this->morphMany(AnalysisRule::class, 'hasanalysisrule');
    }
    /**
     * Get all of the model's Analysis Rules ordered
     * @return mixed
     */
    public function analysisrulesOrdered()
    {
        return $this->analysisrules()
            ->orderBy('id');
    }

    /**
     * Get the lastets of the model's dynamic dynamicattributes
     * @return mixed
     */
    public function latestAnalysisRule()
    {
        return $this->morphOne(AnalysisRule::class, 'hasanalysisrule')->latest('id');
    }

    /**
     * Get the oldest of the model's dynamic dynamicattributes
     * @return mixed
     */
    public function oldestAnalysisRule()
    {
        return $this->morphOne(AnalysisRule::class, 'hasanalysisrule')->oldest('id');
    }

    #region Custom Functions

    /**
     * @param Model|AnalysisRuleType $analysisruletype
     * @param string $title
     * @param array $inneranalysisrule_attributes
     * @param string|null $rule_result_for_notification
     * @param Status|null $status
     * @param string|null $description
     * @return AnalysisRule
     */
    public function addAnalysisRule(Model|AnalysisRuleType $analysisruletype, string $title, array $inneranalysisrule_attributes = [], string $rule_result_for_notification = null, Status $status = null, string $description = null): AnalysisRule
    {
        $num_ord = $this->analysisrules()->count() + 1;     // set the analysis rule number order
        $analysisrule = AnalysisRule::createNew(
            $analysisruletype,
            $title,
            $rule_result_for_notification,
            $inneranalysisrule_attributes,
            $status,
            $description,
            $num_ord
        );                                                  // create new AnalysisRule + IInnerAnalysisRule
        $this->analysisrules()->save($analysisrule);        // attach the new AnalysisRule to the current model object

        $analysisrule->save();                              // save the association from the AnalysisRule

        return $analysisrule;
    }

    protected function initializeHasAnalysisRules()
    {
        $this->with = array_unique(array_merge($this->with, ['analysisrules']));
    }
}
