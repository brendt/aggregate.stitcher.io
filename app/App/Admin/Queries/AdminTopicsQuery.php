<?php

namespace App\Admin\Queries;

use App\Admin\Filters\FuzzyFilter;
use Domain\Post\Models\Topic;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminTopicsQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Topic::query();

        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::custom('search', new FuzzyFilter(
                'name'
            )),
        ]);

        $this->allowedSorts('name');

        $this->defaultSort('name');
    }
}
