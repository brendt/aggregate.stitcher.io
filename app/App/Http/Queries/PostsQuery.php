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
        $query->whereActive();

        $query
            ->leftJoin('post_tags', 'post_tags.post_id', '=', 'posts.id')
            ->leftJoin('tags', 'tags.id', '=', 'post_tags.tag_id')
            ->leftJoin('topics', 'tags.topic_id', '=', 'topics.id')
            ->with('tags', 'views', 'source')
            ->distinct()
            ->select('posts.*');

        /** @var \Domain\User\Models\User $user */
        $user = $request->user();

        if ($user) {
            $query->whereNotMuted($user);

            if ($user->getLanguages()->isNotEmpty()) {
                $query->whereLanguageIn($user->getLanguages());
            }
        }

        parent::__construct($query, $request);

        $this
            ->allowedSorts(['date_created'])
            ->allowedFilters([
                Filter::exact('tag', 'tags.slug'),
                Filter::exact('language', 'posts.language'),
                Filter::exact('topic', 'topics.slug'),
                Filter::exact('source', 'sources.website'),
                Filter::custom('unread', new UnreadFilter($user)),
            ])
            ->defaultSort('-date_created');
    }
}
