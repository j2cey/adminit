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
 * @property bool|null $retrieve_by_name
 * @property bool|null $retrieve_by_wildcard
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
        return [
            //
        ];
    }

    protected function getRetrieveByNameNormalized() {
        return is_null($this->input('retrieve_by_name')) ? false : $this->input('retrieve_by_name');
    }

    protected function getRetrieveByWildcardNormalized() {
        return is_null($this->input('retrieve_by_wildcard')) ? false : $this->input('retrieve_by_wildcard');
    }
}
