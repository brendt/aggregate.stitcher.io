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

        $ageIndex = -1 * ($post->created_at->diffInDays(now()) / 6);

        $viewIndex = $post->view_count / $this->averageViewCount;

        $voteIndex = $post->vote_count * 1.5;

        $popularityIndex = ($ageIndex + $viewIndex + $voteIndex) * 100;

        if ($popularityIndex < 0) {
            $popularityIndex = 0;
        }

        return $post->savePopularityIndex($popularityIndex);
    }
}
