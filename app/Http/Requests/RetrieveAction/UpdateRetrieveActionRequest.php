<?php

namespace App\Http\Requests\RetrieveAction;

use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\RetrieveAction;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRetrieveActionTypeRequest
 * @package App\Http\Requests\RetrieveActionType
 *
 * @property RetrieveAction $retrieveaction
 */
class UpdateRetrieveActionRequest extends RetrieveActionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('retrieveaction-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return RetrieveAction::updateRules($this->retrieveaction);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
            'retrieveactiontype' => $this->setRelevantRetrieveActionType($this->input('retrieveactiontype'),'code', true),
        ]);
    }
}
