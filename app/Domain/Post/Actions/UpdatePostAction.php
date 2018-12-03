<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\PostData;
use Domain\Post\Models\Post;

class UpdatePostAction
{
    public function execute(Post $post, PostData $postData): Post
    {
        $post->fill($postData->all());

        $post->save();

        return $post->refresh();
    }
}
