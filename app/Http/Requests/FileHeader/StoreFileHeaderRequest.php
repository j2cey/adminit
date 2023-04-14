<?php

namespace App\Http\Requests\FileHeader;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FileHeader\FileHeader;
use App\Contracts\FileHeader\IHasFileHeader;

/**
 * Class StoreFileHeaderRequest
 * @package App\Http\Requests\FileHeader
 *
 * @property IHasFileHeader $model
 * @property string $model_type
 */
class StoreFileHeaderRequest extends FileHeaderRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FileHeader()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FileHeader::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'), "íd", false),
            'model' => $this->input('model_type')::where('id', $this->input('model_id'))->first(),
        ]);
    }
}