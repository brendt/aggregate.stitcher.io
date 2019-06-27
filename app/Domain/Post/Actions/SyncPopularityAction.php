<?php

namespace Domain\Post\Actions;

use Domain\Post\Models\Post;

final class SyncPopularityAction
{
    /** @var int */
    private $averageViewCount;

    /** @var int */
    private $averageVoteCount;

    public function __construct(int $averageViewCount, int $averageVoteCount)
    {
        $this->averageViewCount = $averageViewCount;
        $this->averageVoteCount = $averageVoteCount;
    }

    public function __invoke(Post $post): Post
    {
        if ($post->created_at < now()->subWeeks(2)) {
            return $post->savePopularityIndex(-1);
        }

        $ageIndex = round($post->created_at->diffInDays(now()) / 5);

        $viewIndex = $post->view_count_weekly / $this->averageViewCount;

        $voteIndex = $post->vote_count;

        return $post->savePopularityIndex($ageIndex + $viewIndex + $voteIndex);
    }
}
