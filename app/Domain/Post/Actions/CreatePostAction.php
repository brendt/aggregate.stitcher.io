<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\PostData;
use Domain\Post\Events\PostChangedEvent;
use Domain\Post\Models\Post;
use Domain\Post\Models\PostTag;
use Domain\Source\Models\Source;

final class CreatePostAction
{
    public function __invoke(Source $source, PostData $postData): void
    {
        $post = Post::create(array_merge([
            'source_id' => $source->id,
        ], $postData->except('tag_ids')->toArray()));

        foreach ($postData->tag_ids as $tag_id) {
            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tag_id,
            ]);
        }

        $source->post_count = $source->posts()->count();

        $source->save();

        event(PostChangedEvent::create($post));
    }
}
