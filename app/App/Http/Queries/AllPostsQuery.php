<?php

namespace App\Http\Queries;

use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Illuminate\Http\Request;

class AllPostsQuery extends PostsQuery
{
    public function __construct(Request $request)
    {
        $query = Post::query();

        parent::__construct($query, $request);
    }

    public function whereTopic(Topic $topic): AllPostsQuery
    {
        $this->query->where('topic_id', $topic->id);

        return $this;
    }

    public function whereTag(Tag $tag): AllPostsQuery
    {
        $this->query->where('tag_id', $tag->id);

        return $this;
    }
}
