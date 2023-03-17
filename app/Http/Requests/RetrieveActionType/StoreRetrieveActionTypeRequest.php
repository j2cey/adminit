<?php

namespace App\Http\Requests\RetrieveActionType;

use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\RetrieveActionType;

/**
 * Class StoreRetrieveActionTypeRequest
 * @package App\Http\Requests\RetrieveActionType
 *
 *
 */
class StoreRetrieveActionTypeRequest extends RetrieveActionTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('retrieveactiontype-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RetrieveActionType::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([

        ]);
    }
}
