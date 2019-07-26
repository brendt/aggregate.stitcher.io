<?php

namespace App\Http\Queries;

use App\Http\Filters\FuzzyFilter;
use Domain\Post\Models\Tag;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
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
            Filter::exact('topic_id'),
            Filter::custom('search', new FuzzyFilter(
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
