<?php

namespace App\Http\Requests\DynamicAttribute;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

class DynamicAttributeRequest extends FormRequest
{
    use RequestTraits;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
