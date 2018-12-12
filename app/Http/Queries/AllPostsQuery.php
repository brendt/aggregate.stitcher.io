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
            ->leftJoin('post_tags', 'post_tags.post_id', '=', 'posts.id')
            ->leftJoin('tags', 'tags.id', '=', 'post_tags.tag_id')
            ->distinct()
            ->select('posts.*');

        parent::__construct($query, $request);
    }
}
