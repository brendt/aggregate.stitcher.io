<?php

namespace App\Domain\Post\Projectors;

use App\Domain\Post\Events\AddViewEvent;
use Domain\Post\Actions\UpdateViewCountAction;
use Domain\Post\Models\Post;
use Domain\Post\Models\View;
use Domain\User\Models\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class ViewProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        AddViewEvent::class => 'addView',
    ];

    /** @var \Domain\Post\Actions\UpdateViewCountAction */
    private $updateViewCountAction;

    public function __construct(UpdateViewCountAction $calculateViewsAction)
    {
        $this->updateViewCountAction = $calculateViewsAction;
    }

    public function addView(AddViewEvent $event): void
    {
        $user = $event->user_uuid
            ? User::whereUuid($event->user_uuid)->firstOrFail()
            : null;

        $post = Post::whereUuid($event->post_uuid)->firstOrFail();

        View::create([
            'user_id' => optional($user)->id,
            'post_id' => $post->id,
        ]);

        $this->updateViewCountAction->execute($post->refresh());
    }
}
