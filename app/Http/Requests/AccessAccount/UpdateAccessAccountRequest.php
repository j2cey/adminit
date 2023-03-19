<?php

namespace App\Http\Requests\AccessAccount;

use App\Models\Access\AccessAccount;
use Illuminate\Support\Facades\Auth;

class UpdateAccessAccountRequest extends AccessAccountRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('accessaccount-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AccessAccount::updateRules($this->accessaccount);
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
