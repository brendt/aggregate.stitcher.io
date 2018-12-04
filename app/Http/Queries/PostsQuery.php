<?php

namespace App\Http\Queries;

use Domain\Post\Models\Post;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PostsQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Post::query()
            ->whereActive()
            ->select('posts.*');

        parent::__construct($query, $request);

        $this
            ->allowedSorts(['date_created'])
            ->defaultSort('-date_created');
    }
}
