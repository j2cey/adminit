<?php

namespace App\Http\Requests\SelectedRetrieveAction;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use App\Contracts\SelectedRetrieveAction\IHasSelectedRetrieveActions;

/**
 * Class StoreSelectedRetrieveActionRequest
 * @package App\Http\Requests\SelectedRetrieveAction
 *
 * @property IHasSelectedRetrieveActions $model
 * @property string $code
 * @property string|null $description
 * @property mixed $actionvalue_label
 * @property mixed $actionvalue_valuetype
 * @property mixed $actionvalue
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
            'model' => $this->input('model_type')::find($this->input('model_id'))->first(),
            'actionvalue_valuetype' => (is_null($this->input('actionvalue_valuetype'))) ? null : $this->input('actionvalue_valuetype')['value'],
            'retrieveaction' => $this->setRelevantRetrieveAction(RetrieveAction::class, $this->input('retrieveaction'),'code', false),
        ]);
    }
}
