<?php

namespace App\Http\Requests\AccessAccount;

use App\Enums\Permissions;
use App\Models\Access\AccessAccount;
use Illuminate\Support\Facades\Auth;

class StoreAccessAccountRequest extends AccessAccountRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AccessAccount()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AccessAccount::createRules();
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
