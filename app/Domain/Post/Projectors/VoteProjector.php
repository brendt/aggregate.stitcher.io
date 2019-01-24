<?php

namespace Domain\Post\Projectors;

use Domain\Post\Actions\UpdateVoteCountAction;
use Domain\Post\Events\AddVoteEvent;
use Domain\Post\Events\RemoveVoteEvent;
use Domain\Post\Models\Post;
use Domain\Post\Models\Vote;
use Domain\User\Models\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class VoteProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        AddVoteEvent::class => 'addVote',
        RemoveVoteEvent::class => 'removeVote',
    ];

    /** @var \Domain\Post\Actions\UpdateVoteCountAction */
    private $updateVoteCountAction;

    public function __construct(UpdateVoteCountAction $calculateVotesAction)
    {
        $this->updateVoteCountAction = $calculateVotesAction;
    }

    public function addVote(AddVoteEvent $event): void
    {
        $user = User::whereUuid($event->user_uuid)->firstOrFail();

        $post = Post::whereUuid($event->post_uuid)->firstOrFail();

        Vote::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->updateVoteCountAction->__invoke($post->refresh());
    }

    public function removeVote(RemoveVoteEvent $event): void
    {
        $user = User::whereUuid($event->user_uuid)->firstOrFail();

        $post = Post::whereUuid($event->post_uuid)->firstOrFail();

        Vote::query()
            ->whereUser($user)
            ->wherePost($post)
            ->delete();

        $this->updateVoteCountAction->__invoke($post->refresh());
    }
}
