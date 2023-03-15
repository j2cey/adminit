<?php

namespace App\Http\Requests\AccessProtocole;

use App\Models\Status;
use App\Models\AccessProtocole;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AccessProtocoleRequest
 * @package App\Http\Requests\AccessProtocole
 *
 * @property string $name
 * @property string $code
 *
 * @property string|null $description
 *
 * @property Status $status
 */
class AccessProtocoleRequest extends FormRequest
{
    use RequestTraits;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return AccessProtocole::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return AccessProtocole::messagesRules();
    }
}
