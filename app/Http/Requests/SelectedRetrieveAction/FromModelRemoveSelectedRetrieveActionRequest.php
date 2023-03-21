<?php

namespace App\Http\Requests\SelectedRetrieveAction;

use App\Models\RetrieveAction\SelectedRetrieveAction;
use App\Contracts\SelectedRetrieveAction\IHasSelectedRetrieveActions;

/**
 * Class FromModelAddSelectedRetrieveActionRequest
 * @package App\Http\Requests\SelectedRetrieveAction
 *
 * @property IHasSelectedRetrieveActions $model
 * @property SelectedRetrieveAction $selectedretrieveaction
 */
class FromModelRemoveSelectedRetrieveActionRequest extends SelectedRetrieveActionRequest
{
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
        return [
            'selectedretrieveaction' => ['required'],
            'model_type' => ['required'],
            'model' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(SelectedRetrieveAction::messagesRules(), [
            'selectedretrieveaction.required' => "Prière de renseigner l'action sélevctionnée'",
            'model_type.required' => "Prière de renseigner le type de Modèle",
            'model.required' => "Prière de renseigner le Modèle",
        ]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'model' => $this->getRelevantModel($this->input('model_type'), $this->input('model'),'id', false),
            'selectedretrieveaction' => $this->getRelevantModel(SelectedRetrieveAction::class, $this->input('selectedretrieveaction'),'id', false),
        ]);
    }
}
