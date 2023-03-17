<?php

namespace App\Http\Requests\RetrieveAction;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\ReportFile\RetrieveAction;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportFile\RetrieveActionType;

/**
 * Class RetrieveActionRequest
 * @package App\Http\Requests\RetrieveAction
 *
 * @property string $name
 * @property string $code
 * @property string|null $description
 *
 * @property Status $status
 * @property RetrieveActionType $retrieveactiontype
 */
class RetrieveActionRequest extends FormRequest
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
        return RetrieveAction::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return RetrieveAction::messagesRules();
    }
}
