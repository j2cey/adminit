<?php

namespace App\Http\Requests\Setting;

use App\Models\Setting;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SettingRequest
 * @package App\Http\Requests\Setting
 *
 * @property string $name
 * @property string|null $full_path
 * @property string|null $value
 * @property string $type
 * @property string $array_sep
 * @property string|null $description
 */
class SettingRequest extends FormRequest
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

    public function setRelevantGroup($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Setting::where('id', $value['id'])->first() : null;
    }
}
