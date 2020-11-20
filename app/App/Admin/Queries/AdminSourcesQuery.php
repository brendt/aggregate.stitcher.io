<?php

namespace App\Admin\Queries;

use App\Admin\Filters\FuzzyFilter;
use Domain\Source\Models\Source;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminSourcesQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Source::query()
            ->leftJoin('source_topics', 'source_topics.source_id', '=', 'sources.id')
            ->leftJoin('topics', 'topics.id', '=', 'source_topics.topic_id')
            ->leftJoin('post_reports', 'post_reports.source_id', '=', 'sources.id')
            ->select('sources.*')
            ->with(['topics'])
            ->withCount(['reports'])
            ->distinct();

        parent::__construct($query, $request);

        $this->allowedFilters(
            [
                AllowedFilter::exact('is_active'),
                AllowedFilter::scope('reported'),
                AllowedFilter::custom('search', new FuzzyFilter('website', 'url', 'twitter_handle', 'topics.name')),
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
