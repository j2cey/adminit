<?php

namespace App\Http\Requests\RetrieveActionType;

use Illuminate\Support\Facades\Auth;
use App\Models\RetrieveAction\RetrieveActionType;

/**
 * Class UpdateRetrieveActionTypeRequest
 * @package App\Http\Requests\RetrieveActionType
 *
 * @property RetrieveActionType $retrieveactiontype
 */
class UpdateRetrieveActionTypeRequest extends RetrieveActionTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('retrieveactiontype-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return RetrieveActionType::updateRules($this->retrieveactiontype);
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
        ]);
    }
}
