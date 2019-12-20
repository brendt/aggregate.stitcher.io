<?php

namespace App\Admin\Queries;

use App\Admin\Filters\FuzzyFilter;
use Domain\Post\Models\Tag;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminTagsQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Tag::query()
            ->join('topics', 'tags.topic_id', '=', 'topics.id')
            ->select('tags.*');

        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::exact('topic_id'),
            AllowedFilter::custom('search', new FuzzyFilter(
                'keywords',
                'tags.slug',
                'topics.slug',
                'tags.name',
                'topics.name'
            )),
        ]);

        $this->allowedSorts('topics.name', 'tags.name');

        $this->defaultSort('tags.name');
    }
}
