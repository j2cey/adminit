<?php

namespace App\Http\Requests\FormatTextWeight;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\FormatRule\FormatTextWeight;

/**
 * Class FormatTextWeightRequest
 * @package App\Http\Requests\FormatTextWeight
 *
 * @property string $format_value
 * @property string $comment
 *
 */
class FormatTextWeightRequest extends FormRequest
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
        return FormatTextWeight::defaultRules();
    }
}
