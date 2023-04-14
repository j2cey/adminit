<?php

namespace App\Http\Requests\FileHeader;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FileHeader\FileHeader;

/**
 * Class StoreFileHeaderRequest
 * @package App\Http\Requests\FileHeader
 *
 * @property FileHeader $fileheader
 */
class UpdateFileHeaderRequest extends FileHeaderRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FileHeader()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FileHeader::updateRules($this->fileheader);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->getrelevantModelByCode(Status::class, $this->status, true),
        ]);
    }
}
