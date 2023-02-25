<?php

namespace App\Search\Queries;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;

class SubjectSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query(): Builder
    {
        $query = Subject::query();
        $user = auth()->user();

        //dd($this);

        if ($this->params->search->hasFilter()) {
            $category = $this->getCategoryCrit($this->params->search->search);
            $status = $this->getStatutCrit($this->params->search->search);

            if ($category) {
                $query
                    ->where('category_id', $category);
            }
            if ($status) {
                $query
                    ->where('status_id', $category);
            }
        }

        return $query;
    }

    private function getDateRemiseRangeCrit($search) {
        $search_arr = explode('|', $search);
        $dateremise_range = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "dateremise_du") {
                $dateremise_range[0] = $crit_arr[1];
            } elseif ($crit_arr[0] === "dateremise_au") {
                $dateremise_range[1] = $crit_arr[1];
            }
        }
        return is_null($dateremise_range) ? null : (count($dateremise_range) === 2 ? $dateremise_range : null);
    }

    private function getCategoryCrit($search) {
        $search_arr = explode('|', $search);
        $category = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "category") {
                $category = $crit_arr[1];
            }
        }
        return $category;
    }

    private function getStatutCrit($search) {
        $search_arr = explode('|', $search);
        $status = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "status") {
                $status = $crit_arr[1];
            }
        }
        return $status;
    }
}
