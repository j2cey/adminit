<?php

namespace App\Http\Requests\HighlightTextWeight;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRules\HighlightTextWeight;

/**
 * Class HighlightTextWeightRequest
 * @package App\Http\Requests\HighlightTextWeight
 *
 * @property string $highlight
 * @property string $comment
 *
 * @property HighlightTextWeight $highlighttextweight
 */
class HighlightTextWeightRequest extends FormRequest
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
        return HighlightTextWeight::defaultRules();
    }
}
