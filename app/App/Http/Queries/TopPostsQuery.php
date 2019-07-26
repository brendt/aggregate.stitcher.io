<?php

namespace App\Http\Queries;

use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class TopPostsQuery extends PostsQuery
{
    public function __construct(Request $request)
    {
        $query = Post::query()
            ->orderByDesc('popularity_index')
            ->orderByDesc('view_count_weekly');

        parent::__construct($query, $request);
    }
}
