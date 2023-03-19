<?php

namespace App\Http\Requests\ReportServer;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Foundation\Http\FormRequest;


/**
 * Class StoreReportServerRequest
 * @package App\Http\Requests\ReportServer
 *
 *
 */
class StoreReportServerRequest extends ReportServerRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportServer()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ReportServer::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
            'osserver' => $this->setRelevantOsServer($this->input('osserver'),'id', false),
        ]);
    }
}
