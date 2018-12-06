<?php

namespace App\Http\Queries;

use Domain\Post\Models\Post;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class PostsQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Post::query()
            ->whereActive()
            ->with('tags')
            ->join('post_tags', 'post_tags.post_id', '=', 'posts.id')
            ->join('tags', 'tags.id', '=', 'post_tags.tag_id')
            ->distinct()
            ->select('posts.*');

        parent::__construct($query, $request);

        $this
            ->allowedSorts(['date_created'])
            ->allowedFilters([
                Filter::exact('tags.name'),
            ])
            ->defaultSort('-date_created');
    }
}
