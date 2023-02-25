<?php

namespace App\Http\Requests\HighlightTextColor;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRules\HighlightTextColor;

/**
 * Class HighlightTextColorRequest
 * @package App\Http\Requests\HighlightTextColor
 *
 * @property string $highlight
 * @property string $comment
 *
 * @property HighlightTextColor $highlighttextcolor
 */
class HighlightTextColorRequest extends FormRequest
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
        return HighlightTextColor::defaultRules();
    }
}
