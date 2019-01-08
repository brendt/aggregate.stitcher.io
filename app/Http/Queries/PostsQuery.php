<?php

namespace App\Http\Queries;

use App\Http\Filters\UnreadFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

abstract class PostsQuery extends QueryBuilder
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Domain\Post\Models\Post $query
     * @var \Illuminate\Http\Request $request
     */
    public function __construct(Builder $query, Request $request)
    {
        $query->with('tags', 'views', 'source');

        $user = $request->user();

        if ($user) {
            $query->whereNotMuted($user);
        }

        parent::__construct($query, $request);

        $this
            ->allowedSorts(['date_created'])
            ->allowedFilters([
                Filter::exact('tags.name'),
                Filter::exact('sources.website'),
                Filter::custom('unread', new UnreadFilter($request->user()))
            ])
            ->defaultSort('-date_created');
    }
}
