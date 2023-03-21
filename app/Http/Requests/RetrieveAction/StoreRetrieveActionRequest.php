<?php

namespace App\Http\Requests\RetrieveAction;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\RetrieveAction\RetrieveAction;

/**
 * Class StoreRetrieveActionTypeRequest
 * @package App\Http\Requests\RetrieveActionType
 *
 *
 */
class StoreRetrieveActionRequest extends RetrieveActionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can( Permissions::RetrieveAction()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return RetrieveAction::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'code' => $this->getCodeField(),
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
            'retrieveactiontype' => $this->setRelevantRetrieveActionType($this->input('retrieveactiontype'),'code', false),
        ]);
    }
}
