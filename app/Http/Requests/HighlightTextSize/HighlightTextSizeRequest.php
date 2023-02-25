<?php

namespace App\Http\Requests\HighlightTextSize;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRules\HighlightTextSize;

/**
 * Class HighlightTextSizeRequest
 * @package App\Http\Requests\HighlightTextSize
 *
 * @property integer $highlight
 * @property string $comment
 *
 * @property HighlightTextSize $highlighttextsize
 */
class HighlightTextSizeRequest extends FormRequest
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
        return HighlightTextSize::defaultRules();
    }
}
