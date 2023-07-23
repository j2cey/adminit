<?php

namespace App\Http\Requests\Permission;

use App\Models\Authorization\Permission;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PermissionRequest
 * @package App\Http\Requests\Permission
 *
 * @property string $name
 * @property integer $level
 * @property string $guard_name
 * @property string|null $description
 *
 * @property Permission $permission
 */
class PermissionRequest extends FormRequest
{
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
        return Permission::defaultRules();
    }
}
