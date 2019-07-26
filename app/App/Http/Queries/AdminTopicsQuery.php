<?php

namespace App\Http\Queries;

use App\Http\Filters\FuzzyFilter;
use Domain\Post\Models\Topic;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminTopicsQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Topic::query();

        parent::__construct($query, $request);

        $this->allowedFilters([
            Filter::custom('search', new FuzzyFilter(
                'name'
            )),
        ]);

        $this->allowedSorts('name');

        $this->defaultSort('name');
    }
}
