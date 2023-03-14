<?php

namespace App\Http\Requests\OsFamily;

use Illuminate\Support\Facades\Auth;
use App\Models\OsAndServer\OsFamily;

/**
 * Class UpdateOsFamilyRequest
 * @package App\Http\Requests\OsFamily
 *
 * @property OsFamily $osfamily
 */
class UpdateOsFamilyRequest extends OsFamilyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('osfamily-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return OsFamily::updateRules($this->osfamily);
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
