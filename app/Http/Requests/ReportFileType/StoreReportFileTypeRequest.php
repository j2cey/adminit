<?php

namespace App\Http\Requests\ReportFileType;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\ReportFileType;

class StoreReportFileTypeRequest extends ReportFileTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportFileType()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ReportFileType::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'filemimetype' => $this->setRelevantFileMimeType($this->input('filemimetype'),'id', false),
            'status' => $this->getRelevantModel(Status::class, $this->input('status'),'code', false),
        ]);
    }
}
