<?php

namespace App\Http\Requests\FormatType;

use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\FormattedValue\IFormatType;

/**
 * Class ComparisonTypeRequest
 * @package App\Http\Requests\ComparisonType
 *
 * @property string $name
 * @property string $code
 * @property string|IFormatType $formattype_class
 *
 * @property string $description
 *
 * @property Status $status
 */
class FormatTypeRequest extends FormRequest
{
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
