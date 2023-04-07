<?php

namespace App\Http\Requests\FormattedValue;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormattedValue\FormatType;
use App\Models\FormattedValue\FormattedValue;
use App\Contracts\FormattedValue\IHasFormattedValue;

/**
 * Class StoreFormattedValueRequest
 * @package App\Http\Requests\FormattedValue
 *
 * @property IHasFormattedValue $model
 * @property string $model_type
 */
class StoreFormattedValueRequest extends FormattedValueRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormattedValue()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormattedValue::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
            'model' => $this->input('model_type')::find($this->input('model_id'))->first(),
            'formattype' => $this->getRelevantModel(FormatType::class, $this->input('formattype'), 'id'),
        ]);
    }
}
