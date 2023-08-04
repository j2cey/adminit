<?php

namespace App\Http\Requests\TreatmentOperation;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\TreatmentOperation;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * Class StoreTreatmentOperationRequest
 * @package App\Http\Requests\TreatmentOperation
 *
 * @property TreatmentOperation $treatmentoperation
 */
class UpdateTreatmentOperationRequest extends TreatmentOperationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::TreatmentOperation()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return TreatmentOperation::updateRules($this->treatmentoperation);
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
            'reporttreatmentstep' => $this->getRelevantModel(ReportTreatmentStep::class, $this->input('reporttreatmentstep'),'id', true),
            'parentoperation' => $this->getRelevantModel(TreatmentOperation::class, $this->input('parentoperation'),'id', true),
        ]);
    }
}
