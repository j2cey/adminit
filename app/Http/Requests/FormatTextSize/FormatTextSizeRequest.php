<?php

namespace App\Http\Requests\FormatTextSize;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\FormatRule\FormatTextSize;

/**
 * Class FormatTextSizeRequest
 * @package App\Http\Requests\FormatTextSize
 *
 * @property integer $format_value
 * @property string $comment
 *
 */
class FormatTextSizeRequest extends FormRequest
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
        return FormatTextSize::defaultRules();
    }
}
