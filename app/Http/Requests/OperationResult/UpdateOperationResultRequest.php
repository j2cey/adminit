<?php

namespace App\Http\Requests\OperationResult;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\OperationResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class StoreOperationResultRequest
 * @package App\Http\Requests\OperationResult
 *
 * @property OperationResult $operationresult
 */
class UpdateOperationResultRequest extends OperationResultRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::OperationResult()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return OperationResult::updateRules($this->operationresult);
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
            'reporttreatmentstepresult' => $this->getRelevantModel(ReportTreatmentStepResult::class, $this->input('reporttreatmentstepresult'),'id', true),
            'parentoperation' => $this->getRelevantModel(OperationResult::class, $this->input('parentoperation'),'id', true),
        ]);
    }
}
