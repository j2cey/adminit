<?php

namespace App\Http\Requests\SelectedRetrieveAction;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;

/**
 * Class StoreSelectedRetrieveActionRequest
 * @package App\Http\Requests\SelectedRetrieveAction
 *
 * @property string $code
 * @property string|null $description
 *
 *
 */
class StoreSelectedRetrieveActionRequest extends SelectedRetrieveActionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can( Permissions::SelectedRetrieveAction()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return SelectedRetrieveAction::createRules();
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
            'retrieveaction' => $this->setRelevantRetrieveAction(RetrieveAction::class, $this->input('retrieveaction'),'code', false),
        ]);
    }
}
