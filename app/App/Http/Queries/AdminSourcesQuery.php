<?php

namespace App\Http\Queries;

use App\Http\Filters\FuzzyFilter;
use Domain\Source\Models\Source;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminSourcesQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Source::query();

        parent::__construct($query, $request);

        $this->allowedFilters([
            Filter::exact('is_active'),
            Filter::custom('search', new FuzzyFilter('website', 'url')),
        ]);

        $this->allowedSorts([
            'post_count',
            'created_at',
            'url',
        ]);

        $this->defaultSort('-created_at');
    }
}
