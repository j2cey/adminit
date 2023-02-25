<?php

namespace App\Http\Requests\Report;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ISearchFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest implements ISearchFormRequest
{
    use SearchRequest;

    /**
     * @inheritDoc
     */
    protected function orderByFields(): array
    {
        return ['title', 'report_type_id'];
    }

    /**
     * @inheritDoc
     */
    protected function defaultOrderByField(): string
    {
        return 'title';
    }

    protected function getCustomPayload()
    {
        $payload = "";
        //$payload = $this->addToPayload($payload, 'search', $this->search);
        $payload = $this->addToPayload($payload, 'createdat_du', substr($this->createdat_du, 0, 10));
        $payload = $this->addToPayload($payload, 'createdat_au', substr($this->createdat_au, 0, 10));

        $payload = $this->addToPayload($payload, 'status', $this->status);
        $payload = $this->addToPayload($payload, 'reporttype', $this->reporttype);

        return $payload;
    }
}
