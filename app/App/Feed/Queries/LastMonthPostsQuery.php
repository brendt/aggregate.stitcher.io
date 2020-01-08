<?php

namespace App\Feed\Queries;

use Carbon\Carbon;
use Domain\Post\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class LastMonthPostsQuery extends PostsQuery
{
    public function __construct(Request $request)
    {
        $query = Post::query()
            ->whereDate('date_created', '>', Carbon::make('-1 month'));

        parent::__construct($query, $request);
    }

    public function whereTags(Collection $tags): self
    {
        $this->query->whereIn('tag_id', $tags->pluck('id'));

        return $this;
    }
}
