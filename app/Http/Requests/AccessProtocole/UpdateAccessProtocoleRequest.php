<?php

namespace App\Http\Requests\AccessProtocole;

use App\Models\AccessProtocole;
use Illuminate\Support\Facades\Auth;

/**
 * Class UpdateAccessProtocoleRequest
 * @package App\Http\Requests\AccessProtocole
 *
 * @property AccessProtocole $accessprotocole
 */
class UpdateAccessProtocoleRequest extends AccessProtocoleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('accessprotocole-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return AccessProtocole::updateRules($this->accessprotocole);
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
