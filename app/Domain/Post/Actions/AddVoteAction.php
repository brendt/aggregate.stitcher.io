<?php

namespace Domain\Post\Actions;

use Domain\Post\Models\Post;
use Domain\Post\Models\Vote;
use Domain\User\Models\User;

final class AddVoteAction
{
    /** @var \Domain\Post\Actions\UpdateVoteCountAction */
    private $updateVoteCountAction;

    public function __construct(UpdateVoteCountAction $calculateVotesAction)
    {
        $this->updateVoteCountAction = $calculateVotesAction;
    }

    public function __invoke(Post $post, User $user): void
    {
        Vote::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->updateVoteCountAction->__invoke($post->refresh());
    }
}
