<?php

namespace App\Http\Requests\FileHeader;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\FileHeader\FileHeader;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FileHeaderRequest
 * @package App\Http\Requests\FileHeader
 *
 * @property string $title
 * @property string $description
 *
 * @property string $hasfileheader_type
 * @property int $hasfileheader_id
 *
 * @property Status $status
 */
class FileHeaderRequest extends FormRequest
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
        return FileHeader::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return FileHeader::messagesRules();
    }
}
