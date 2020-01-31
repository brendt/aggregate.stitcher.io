<?php

namespace App\Feed\Queries;

use App\Feed\Filters\UnreadFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

abstract class PostsQuery extends QueryBuilder
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Domain\Post\Models\Post
     * @var \Illuminate\Http\Request $request
     */
    public function __construct(Builder $query, Request $request)
    {
        $query->whereActive();

        $query
            ->leftJoin('post_tags', 'post_tags.post_id', '=', 'posts.id')
            ->leftJoin('tags', 'tags.id', '=', 'post_tags.tag_id')
            ->leftJoin('topics', 'tags.topic_id', '=', 'topics.id')
            ->with('tags', 'views', 'source', 'tweets')
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
                AllowedFilter::exact('tag', 'tags.slug'),
                AllowedFilter::exact('language', 'posts.language'),
                AllowedFilter::exact('topic', 'topics.slug'),
                AllowedFilter::exact('source', 'sources.website'),
                AllowedFilter::custom('unread', new UnreadFilter($user)),
            ])
            ->defaultSort('-date_created');
    }
}
