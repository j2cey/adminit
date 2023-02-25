<?php


namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Search\Queries\ReportSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\IReportRepositoryContract;

class ReportRepositoryContract implements IReportRepositoryContract
{
    /**
     * @param ISearchFormRequest $request
     * @return Search
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new ReportSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
