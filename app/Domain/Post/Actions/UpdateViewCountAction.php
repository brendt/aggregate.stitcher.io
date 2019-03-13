<?php

namespace Domain\Post\Actions;

use Domain\Post\Events\ViewCountUpdatedEvent;
use Domain\Post\Models\Post;

final class UpdateViewCountAction
{
    public function __invoke(Post $post): Post
    {
        $viewCount = $post->views()->count();

        $weeklyViewCount = $post->viewsThisWeek()->count();

        $post->view_count = $viewCount;
        $post->view_count_weekly = $weeklyViewCount;
        $post->save();

        event(ViewCountUpdatedEvent::create(
            $post,
            $viewCount,
            $weeklyViewCount
        ));

        return $post->refresh();
    }
}
