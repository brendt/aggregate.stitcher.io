<?php

namespace App\Http\Queries;

use Domain\Post\Models\Post;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class LatestPostsQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Post::query()
            ->whereActive()
            ->leftJoin('posts AS posts_comparison', function (JoinClause $join) {
                $join->on('posts.source_id', '=', 'posts_comparison.source_id')
                    ->on('posts.date_created', '<', 'posts_comparison.date_created');
            })
            ->leftJoin('post_tags', 'post_tags.post_id', '=', 'posts.id')
            ->leftJoin('tags', 'tags.id', '=', 'post_tags.tag_id')
            ->whereNull('posts_comparison.source_id')
            ->select('posts.*')
            ->with('tags');

        parent::__construct($query, $request);

        $this
            ->allowedSorts(['date_created'])
            ->allowedFilters([
                Filter::exact('tags.name'),
            ])
            ->defaultSort('-date_created');
    }
}
