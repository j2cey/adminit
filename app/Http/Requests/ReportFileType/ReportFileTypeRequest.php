<?php

namespace App\Http\Requests\ReportFileType;

use App\Traits\Request\RequestTraits;
use App\Models\ReportFile\FileMimeType;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportFileTypeRequest
 * @package App\Http\Requests\ReportFileType
 *
 * @property string $name
 * @property string $extension
 * @property string|null $description
 *
 * @property FileMimeType $filemimetype
 * @property ReportFileType $reportfiletype
 */
class ReportFileTypeRequest extends FormRequest
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
        return ReportFileType::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportFileType::messagesRules();
    }
}
