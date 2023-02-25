<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ISearchFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FetchRequest
 * @package App\Http\Requests\SubjectResource
 *
 * @property string|null $category
 */
class FetchRequest extends FormRequest  implements ISearchFormRequest
{
    use SearchRequest;

    /**
     * @inheritDoc
     */
    protected function orderByFields() : array
    {
        return ['id', 'title'];
    }

    /**
     * @inheritDoc
     */
    protected function defaultOrderByField() : string
    {
        return 'id';
    }

    protected function getCustomPayload()
    {
        $payload = "";
        $payload = $this->addToPayload($payload, 'search', $this->search);
        $payload = $this->addToPayload($payload, 'category', $this->category);
        $payload = $this->addToPayload($payload, 'statut', $this->statut);

        return $payload;
    }
}
