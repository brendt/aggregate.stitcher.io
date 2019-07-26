<?php

namespace Domain\Post\Actions;

use Domain\Post\Events\VoteRemovedEvent;
use Domain\Post\Models\Post;
use Domain\Post\Models\Vote;
use Domain\User\Models\User;

final class RemoveVoteAction
{
    /** @var \Domain\Post\Actions\UpdateVoteCountAction */
    private $updateVoteCountAction;

    public function __construct(UpdateVoteCountAction $calculateVotesAction)
    {
        $this->updateVoteCountAction = $calculateVotesAction;
    }

    public function __invoke(Post $post, User $user): void
    {
        Vote::query()
            ->whereUser($user)
            ->wherePost($post)
            ->delete();

        event(VoteRemovedEvent::new($user, $post));

        $this->updateVoteCountAction->__invoke($post->refresh());
    }
}
