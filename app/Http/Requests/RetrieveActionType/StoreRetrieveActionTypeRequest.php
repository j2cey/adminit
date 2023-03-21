<?php

namespace App\Http\Requests\RetrieveActionType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\RetrieveAction\RetrieveActionType;

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
        return Auth::user()->can( Permissions::RetrieveActionType()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
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
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
        ]);
    }
}
