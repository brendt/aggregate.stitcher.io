<?php

namespace Domain\Post\Actions;

use Domain\Post\Models\Post;
use Domain\Post\Models\Vote;
use Domain\User\Models\User;

class AddVoteAction
{
    /** @var \Domain\Post\Actions\CalculateVotesAction */
    protected $calculateVotesAction;

    public function __construct(CalculateVotesAction $calculateVotesAction)
    {
        $this->calculateVotesAction = $calculateVotesAction;
    }

    public function execute(Post $post, User $user): Post
    {
        Vote::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        return $this->calculateVotesAction->execute($post->refresh());
    }
}
