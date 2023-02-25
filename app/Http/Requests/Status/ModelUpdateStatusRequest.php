<?php

namespace App\Http\Requests\Status;

use App\Models\Status;
use App\Models\BaseModel;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ModelUpdateStatusRequest
 * @package App\Http\Requests\Status
 *
 * @property Status $status
 * @property BaseModel $model
 */
class ModelUpdateStatusRequest extends FormRequest
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
        return [
            //
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus(
                json_encode( ['code' => $this->input('code')] ),'code', true
            ),
            'model' => $this->input('model_type')::find($this->input('model_id'))->first(),
        ]);
    }
}
