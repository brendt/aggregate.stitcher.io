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
        $query = Source::query()
            ->leftJoin('source_topics', 'source_topics.source_id', '=', 'sources.id')
            ->leftJoin('topics', 'topics.id', '=', 'source_topics.topic_id')
            ->select('sources.*')
            ->with('errorLogs')
            ->distinct();

        parent::__construct($query, $request);

        $this->allowedFilters([
            Filter::exact('is_active'),
            Filter::custom('search', new FuzzyFilter('website', 'url', 'twitter_handle', 'topics.name')),
        ]);

        $this->allowedSorts([
            'post_count',
            'created_at',
            'is_validated',
            'url',
        ]);

        $this->defaultSort('-created_at');
    }
}
