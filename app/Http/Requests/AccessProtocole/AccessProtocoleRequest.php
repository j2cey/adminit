<?php

namespace App\Http\Requests\AccessProtocole;

use App\Models\Status;
use App\Models\AccessProtocole;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportFileTypeRequest
 * @package App\Http\Requests\ReportFileType
 *
 * @property string $name
 *
 * @property string|null $description
 *
 * @property Status $status
 * @property AccessProtocole $accessprotocole
 */
class AccessProtocoleRequest extends FormRequest
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
        return AccessProtocole::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return AccessProtocole::messagesRules();
    }
}
