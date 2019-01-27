<?php

namespace Domain\Post\Actions;

use Domain\Post\Models\Post;
use Domain\Post\Models\View;
use Domain\User\Models\User;

final class AddViewAction
{
    /** @var \Domain\Post\Actions\UpdateViewCountAction */
    private $updateViewCountAction;

    public function __construct(UpdateViewCountAction $calculateViewsAction)
    {
        $this->updateViewCountAction = $calculateViewsAction;
    }

    public function __invoke(Post $post, ?User $user): void
    {
        View::create([
            'user_id' => optional($user)->id,
            'post_id' => $post->id,
        ]);

        $this->updateViewCountAction->__invoke($post->refresh());
    }
}
