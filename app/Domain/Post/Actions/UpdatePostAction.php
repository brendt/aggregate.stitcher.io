<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\PostData;
use Domain\Post\Models\Post;
use Domain\Post\Models\PostTag;

final class UpdatePostAction
{
    public function __invoke(Post $post, PostData $postData): void
    {
        if (! $postData->hasChanges($post)) {
            return;
        }

        $post->fill($postData->except('date_created', 'tag_ids')->toArray());

        $post->save();

        foreach ($postData->tag_ids as $tagId) {
            if ($post->getTagById($tagId)) {
                continue;
            }

            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tagId,
            ]);
        }

        PostTag::query()
            ->wherePost($post)
            ->whereNotIn('tag_id', $postData->tag_ids)
            ->delete();
    }
}
