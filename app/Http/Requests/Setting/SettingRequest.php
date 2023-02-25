<?php

namespace App\Http\Requests\Setting;

use App\Models\Setting;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

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
