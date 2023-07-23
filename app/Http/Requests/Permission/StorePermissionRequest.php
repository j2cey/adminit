<?php

namespace App\Http\Requests\Permission;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\Authorization\Permission;

class StorePermissionRequest extends PermissionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::Permission()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Permission::createRules();
    }
}
