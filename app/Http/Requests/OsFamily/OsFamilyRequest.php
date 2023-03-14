<?php

namespace App\Http\Requests\OsFamily;

use App\Models\Status;
use App\Models\OsAndServer\OsFamily;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class OsFamilyRequest
 * @package App\Http\Requests\OsFamily
 *
 * @property string $name
 * @property string $code
 * @property string|null $description
 *
 * @property Status $status
 */
class OsFamilyRequest extends FormRequest
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
    public function rules() : array
    {
        return OsFamily::defaultRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
        ]);
    }
}
