<?php

namespace App\Http\Requests\SelectedRetrieveAction;

use Illuminate\Support\Facades\Auth;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;

/**
 * Class UpdateRetrieveActionTypeRequest
 * @package App\Http\Requests\RetrieveActionType
 *
 * @property SelectedRetrieveAction $selectedretrieveaction
 */
class UpdateSelectedRetrieveActionRequest extends SelectedRetrieveActionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('selectedretrieveaction-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return SelectedRetrieveAction::updateRules($this->selectedretrieveaction);
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
            'retrieveaction' => $this->setRelevantRetrieveAction(RetrieveAction::class, $this->input('retrieveaction'),'code', true),
        ]);
    }
}
