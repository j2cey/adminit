<?php

namespace App\Traits\AnalysisRules;

use Illuminate\Support\Carbon;
use App\Models\AnalysisRule\AnalysisRule;

trait HasMatchedAnalysisRules
{
    /**
     * Get all of the tags for the post.
     */
    public function matchedanalysisrules()
    {
        return $this->morphToMany(AnalysisRule::class, 'matchedanalysisrule');
    }

    public function addMatchedAnalysisRule(AnalysisRule $analysisrule) {
        return $this->ruleAlreadyMatched($analysisrule) ? false : $this->matchedanalysisrules()->save($analysisrule, ['created_at' => Carbon::now()]);
    }

    public function ruleAlreadyMatched(AnalysisRule $analysisrule) {
        $matched_rules = $this->matchedanalysisrules;

        foreach ($matched_rules as $matched_rule) {
            if ( $matched_rule->id === $analysisrule->id ) {
                return true;
            }
        }

        return false;
    }

    public function resetMatchedAnalysisRules() {
        return $this->matchedanalysisrules()->detach();
    }

    protected function initializeHasMatchedAnalysisRules()
    {
        $this->with = array_unique(array_merge($this->with, ['matchedanalysisrules']));
    }
}
