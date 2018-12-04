<?php

namespace Domain\Post\Actions;

use App\Domain\Post\Events\AddViewEvent;
use Domain\Post\Models\Post;
use Domain\User\Models\User;

class AddViewAction
{
    /** @var \Domain\Post\Actions\UpdateViewCountAction */
    protected $calculateViewsAction;

    public function __construct(UpdateViewCountAction $calculateViewsAction)
    {
        $this->calculateViewsAction = $calculateViewsAction;
    }

    public function execute(Post $post, ?User $user): void
    {
        event(AddViewEvent::create($post, $user));
    }
}
