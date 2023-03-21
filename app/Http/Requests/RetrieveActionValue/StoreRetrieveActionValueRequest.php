<?php

namespace App\Http\Requests\RetrieveActionValue;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\RetrieveAction\RetrieveActionValue;
use App\Models\RetrieveAction\SelectedRetrieveAction;

/**
 * Class StoreRetrieveActionTypeRequest
 * @package App\Http\Requests\RetrieveActionType
 *
 *
 */
class StoreRetrieveActionValueRequest extends RetrieveActionValueRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::RetrieveActionValue()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RetrieveActionValue::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->getRelevantModel(Status::class, $this->input('status'),'code', false),
            'selectedretrieveaction' => $this->getRelevantModel(SelectedRetrieveAction::class, $this->input('selectedretrieveaction'),'id', false),
        ]);
    }
}
