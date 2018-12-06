<?php

namespace App\Domain\Post\Projectors;

use Domain\Post\Actions\UpdateViewCountAction;
use Domain\Post\Events\CreatePostEvent;
use Domain\Post\Events\UpdatePostEvent;
use Domain\Post\Models\Post;
use Domain\Post\Models\PostTag;
use Domain\Source\Models\Source;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class PostProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        CreatePostEvent::class => 'createPost',
        UpdatePostEvent::class => 'updatePost',
    ];

//    public function resetState()
//    {
//        Post::query()->delete();
//    }

    /** @var \Domain\Post\Actions\UpdateViewCountAction */
    private $updateViewCountAction;

    public function __construct(UpdateViewCountAction $calculateViewsAction)
    {
        $this->updateViewCountAction = $calculateViewsAction;
    }

    public function createPost(CreatePostEvent $event): void
    {
        $source = Source::whereUuid($event->source_uuid)->firstOrFail();

        $post = Post::create(array_merge([
            'source_id' => $source->id,
        ], $event->post_data));

        foreach ($event->tag_ids as $tag_id) {
            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tag_id,
            ]);
        }
    }

    public function updatePost(UpdatePostEvent $event): void
    {
        $post = Post::whereUuid($event->post_uuid)->firstOrFail();

        $data = $event->post_data;

        unset($data['date_created']);

        $post->fill($data);

        $post->save();
    }
}
