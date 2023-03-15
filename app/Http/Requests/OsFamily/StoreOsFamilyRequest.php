<?php

namespace App\Http\Requests\OsFamily;

use App\Models\OsAndServer\OsFamily;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreOsFamilyRequest
 * @package App\Http\Requests\OsFamily
 *
 */
class StoreOsFamilyRequest extends OsFamilyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('osfamily-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return OsFamily::createRules();
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
