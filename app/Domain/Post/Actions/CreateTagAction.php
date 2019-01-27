<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\TagData;
use Domain\Post\Models\Tag;

final class CreateTagAction
{
    public function __invoke(TagData $tagData): void
    {
        Tag::create([
            'topic_id' => $tagData->topic ? $tagData->topic->id : null,
            'name' => $tagData->name,
            'color' => $tagData->color,
            'keywords' => $tagData->keywords,
        ]);
    }
}
