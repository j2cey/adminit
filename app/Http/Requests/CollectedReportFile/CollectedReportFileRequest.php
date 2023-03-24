<?php

namespace App\Http\Requests\CollectedReportFile;

use App\Models\Status;
use App\Models\ReportFile\ReportFile;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportFile\CollectedReportFile;

/**
 * Class ReportFileTypeRequest
 * @package App\Http\Requests\ReportFileType
 *
 * @property string $initial_file_name
 * @property string $local_file_name
 * @property string $file_size
 * @property string|null $description
 *
 * @property Status $status
 * @property ReportFile $reportfile
 * @property CollectedReportFile $collectedreportfile
 */
class CollectedReportFileRequest extends FormRequest
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
        return CollectedReportFile::defaultRules();
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return CollectedReportFile::messagesRules();
    }
}
