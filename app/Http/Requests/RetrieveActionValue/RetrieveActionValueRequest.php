<?php

namespace App\Http\Requests\RetrieveActionValue;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\RetrieveAction\RetrieveActionValue;
use App\Models\RetrieveAction\SelectedRetrieveAction;

/**
 * Class RetrieveActionRequest
 * @package App\Http\Requests\RetrieveAction
 *
 * @property string $label
 * @property string $type
 * @property string $value_string
 * @property int $value_int
 * @property Carbon $value_datetime
 * @property string|null $description
 *
 * @property Status $status
 * @property SelectedRetrieveAction $selectedretrieveaction
 */
class RetrieveActionValueRequest extends FormRequest
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
        return RetrieveActionValue::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return RetrieveActionValue::messagesRules();
    }
}
