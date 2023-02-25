<?php

namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Search\Queries\SubjectSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\ISubjectRepositoryContract;

class SubjectRepository implements ISubjectRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new SubjectSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
