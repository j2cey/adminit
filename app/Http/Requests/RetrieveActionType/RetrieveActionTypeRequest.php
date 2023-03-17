<?php

namespace App\Http\Requests\RetrieveActionType;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportFile\RetrieveActionType;

/**
 * Class OsServerRequest
 * @package App\Http\Requests\OsServer
 *
 * @property string $name
 * @property string $code
 * @property string|null $description
 *
 * @property Status $status
 */
class RetrieveActionTypeRequest extends FormRequest
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
    public function rules()
    {
        return RetrieveActionType::defaultRules();
    }
}
