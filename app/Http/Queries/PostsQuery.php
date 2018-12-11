<?php

namespace App\Http\Queries;

use App\Http\Filters\UnreadFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

abstract class PostsQuery extends QueryBuilder
{
    public function __construct(Builder $query, Request $request)
    {
        parent::__construct($query, $request);

        $this
            ->allowedSorts(['date_created'])
            ->allowedFilters([
                Filter::exact('tags.name'),
                Filter::custom('unread', new UnreadFilter($request->user()))
            ])
            ->defaultSort('-date_created');
    }
}
