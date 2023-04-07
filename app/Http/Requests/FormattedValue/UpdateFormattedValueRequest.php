<?php

namespace App\Http\Requests\FormattedValue;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormattedValue\FormatType;
use App\Models\FormattedValue\FormattedValue;

/**
 * Class StoreFormattedValueRequest
 * @package App\Http\Requests\FormattedValue
 *
 * @property FormattedValue $formattedvalue
 */
class UpdateFormattedValueRequest extends FormattedValueRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormattedValue()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormattedValue::updateRules($this->formattedvalue);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
            'formattype' => $this->getRelevantModel(FormatType::class, $this->input('formattype'), 'id', true),
        ]);
    }
}
