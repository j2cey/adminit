<?php

namespace App\Http\Requests\OsArchitecture;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\OsAndServer\OsArchitecture;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class OsArchitectureRequest
 * @package App\Http\Requests\OsArchitecture
 *
 * @property string $name
 * @property string $code
 * @property string|null $description
 *
 * @property Status $status
 */
class OsArchitectureRequest extends FormRequest
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
        return OsArchitecture::defaultRules();
    }
}
