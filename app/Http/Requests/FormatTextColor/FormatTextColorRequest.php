<?php

namespace App\Http\Requests\FormatTextColor;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\FormatRule\FormatTextColor;

/**
 * Class FormatTextColorRequest
 * @package App\Http\Requests\FormatTextColor
 *
 * @property string $format_value
 * @property string $comment
 *
 */
class FormatTextColorRequest extends FormRequest
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
        return FormatTextColor::defaultRules();
    }
}
