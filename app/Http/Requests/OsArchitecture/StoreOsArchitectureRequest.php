<?php

namespace App\Http\Requests\OsArchitecture;

use Illuminate\Support\Facades\Auth;
use App\Models\OsAndServer\OsArchitecture;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateOsArchitectureRequest
 * @package App\Http\Requests\OsArchitecture
 *
 *
 */
class StoreOsArchitectureRequest extends OsArchitectureRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('osarchitecture-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return OsArchitecture::createRules();
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
