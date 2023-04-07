<?php

namespace App\Http\Requests\FormatType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormattedValue\FormatType;

/**
 * Class StoreFormatTypeRequest
 * @package App\Http\Requests\FormatType
 *
 */
class StoreFormatTypeRequest extends FormatTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormatType()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormatType::createRules();
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
