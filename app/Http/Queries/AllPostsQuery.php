<?php

namespace App\Http\Queries;

use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class AllPostsQuery extends PostsQuery
{
    public function __construct(Request $request)
    {
        $query = Post::query()
            ->whereActive()
            ->distinct()
            ->select('posts.*');

        parent::__construct($query, $request);
    }
}
