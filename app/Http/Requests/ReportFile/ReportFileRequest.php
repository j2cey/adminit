<?php

namespace App\Http\Requests\ReportFile;

use App\Models\Status;
use App\Models\Reports\Report;
use App\Models\ReportFile\ReportFile;
use App\Traits\Request\RequestTraits;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportFileRequest
 * @package App\Http\Requests\ReportFile
 *
 * @property string $name
 * @property string|null $wildcard
 * @property string|null $remotedir_relative_path
 * @property string|null $remotedir_absolute_path
 * @property bool $use_file_extension
 * @property bool $has_headers
 *
 * @property string|null $description
 *
 * @property Status $status
 * @property ReportFileType $reportfiletype
 *
 * @property ReportFile $reportfile
 * @property Report $report
 */
class ReportFileRequest extends FormRequest
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
        return ReportFile::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportFile::messagesRules();
    }
}
