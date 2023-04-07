<?php

namespace App\Http\Requests\FormatType;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\FormattedValue\IInnerFormattedValue;

/**
 * Class FormatTypeRequest
 * @package App\Http\Requests\FormatType
 *
 * @property string $name
 * @property string $code
 * @property string|IInnerFormattedValue $formattype_class
 *
 * @property string $description
 *
 * @property Status $status
 */
class FormatTypeRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
