<?php

namespace App\Http\Requests\DynamicAttribute;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\DynamicAttributes\DynamicAttributeType;

/**
 * Class DynamicAttributeRequest
 * @package App\Http\Requests\DynamicAttribute
 *
 * @property string $name
 * @property string $title
 * @property integer $num_ord
 * @property string|null $description
 *
 * @property string $offset
 * @property integer $max_length
 * @property bool $searchable
 * @property bool $sortable
 * @property bool $can_be_notified
 *
 * @property Status $status
 * @property DynamicAttributeType $dynamicattributetype
 */
class DynamicAttributeRequest extends FormRequest
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
}
