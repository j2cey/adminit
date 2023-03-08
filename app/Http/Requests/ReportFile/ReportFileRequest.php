<?php

namespace App\Http\Requests\ReportFile;

use App\Models\Status;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportFileRequest
 * @package App\Http\Requests\ReportFile
 *
 * @property string $name
 * @property string $extension
 * @property string|null $description
 *
 * @property Status $status
 * @property ReportFileType $reportfiletype
 */
class ReportFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
}
