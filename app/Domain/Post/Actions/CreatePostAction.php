<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\PostData;
use Domain\Post\Models\Post;
use Domain\Source\Models\Source;

class CreatePostAction
{
    public function execute(Source $source, PostData $postData): Post
    {
        return Post::create(array_merge([
            'source_id' => $source->id,
        ], $postData->all()));
    }
}
