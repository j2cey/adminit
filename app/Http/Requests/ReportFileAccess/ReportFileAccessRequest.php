<?php

namespace App\Http\Requests\ReportFileAccess;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

class ReportFileAccessRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
