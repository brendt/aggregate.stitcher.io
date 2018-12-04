<?php

namespace Domain\Post\Actions;

use App\Domain\Post\Events\AddVoteEvent;
use Domain\Post\Models\Post;
use Domain\User\Models\User;

class AddVoteAction
{
    /** @var \Domain\Post\Actions\UpdateVoteCountAction */
    protected $calculateVotesAction;

    public function __construct(UpdateVoteCountAction $calculateVotesAction)
    {
        $this->calculateVotesAction = $calculateVotesAction;
    }

    public function execute(Post $post, User $user): void
    {
        event(AddVoteEvent::create($post, $user));
    }
}
