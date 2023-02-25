<?php

namespace App\Http\Requests\AnalysisRule;

use App\Traits\Request\RequestTraits;
use App\Models\AnalysisRules\AnalysisRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRules\AnalysisRuleType;
use App\Models\DynamicAttributes\DynamicAttribute;

/**
 * Class AnalysisRuleRequest
 * @package App\Http\Requests\AnalysisRule
 *
 * @property string $title
 * @property string $description
 *
 * @property integer $innerrule_id
 *
 * @property boolean $alert_when_allowed
 * @property boolean $alert_when_broken
 *
 * @property integer|null $analysis_rule_type_id
 * @property integer|null $dynamic_attribute_id
 *
 * @property AnalysisRuleType $analysisruletype
 * @property DynamicAttribute $dynamicattribute
 */
class AnalysisRuleRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisRule::defaultRules();
    }
}
