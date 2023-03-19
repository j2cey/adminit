<?php

namespace App\Http\Requests\SelectedRetrieveAction;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;

/**
 * Class SelectedRetrieveActionRequest
 * @package App\Http\Requests\SelectedRetrieveAction
 *
 * @property string $code
 * @property string|null $description
 *
 * @property Status $status
 * @property RetrieveAction $retrieveaction
 */
class SelectedRetrieveActionRequest extends FormRequest
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
    public function rules(): array
    {
        return SelectedRetrieveAction::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return SelectedRetrieveAction::messagesRules();
    }
}
