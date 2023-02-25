<?php

namespace App\Http\Requests\AnalysisHighlight;

use App\Traits\Request\RequestTraits;
use App\Models\AnalysisRules\AnalysisRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRules\AnalysisHighlight;
use App\Models\AnalysisRules\AnalysisHighlightType;

/**
 * Class AnalysisHighlightRequest
 * @package App\Http\Requests\AnalysisHighlight
 *
 * @property string $title
 * @property string $description
 *
 * @property string $when_rule_result_is
 *
 * @property AnalysisHighlightType $highlighttype
 * @property AnalysisRule $analysisrule
 *
 * @property AnalysisHighlight $analysishighlight
 */
class AnalysisHighlightRequest extends FormRequest
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
        return AnalysisHighlight::defaultRules();
    }
}
