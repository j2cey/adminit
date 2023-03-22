<?php

namespace App\Http\Requests\CollectedReportFile;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportFile\CollectedReportFile;

class UpdateCollectedReportFileRequest extends CollectedReportFileRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::CollectedReportFile()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return CollectedReportFile::updateRules($this->collectedreportfile);
    }
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'reportfile' => $this->setRelevantReportFile($this->input('reportfile'),'id', true),
            'status' => $this->getRelevantModel(Status::class, $this->input('status'),'code', true),
        ]);
    }
}
