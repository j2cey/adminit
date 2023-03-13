<?php

namespace App\Http\Requests\AccessAccount;

use App\Models\Status;
use App\Models\AccessAccount;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportFileTypeRequest
 * @package App\Http\Requests\ReportFileType
 *
 * @property string $login
 * @property string $pwd
 * @property string $email
 * @property string $username
 *
 * @property string|null $description
 *
 * @property Status $status
 * @property AccessAccount $accessaccount
 */

class AccessAccountRequest extends FormRequest
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
        return AccessAccount::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return AccessAccount::messagesRules();
    }
}
