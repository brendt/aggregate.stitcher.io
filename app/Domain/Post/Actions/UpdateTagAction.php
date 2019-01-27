<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\TagData;
use Domain\Post\Models\Tag;

final class UpdateTagAction
{
    public function __invoke(Tag $tag, TagData $tagData): void
    {
        if (! $tagData->hasChanges($tag)) {
            return;
        }

        $tag->topic_id = $tagData->topic ? $tagData->topic->id : null;
        $tag->name = $tagData->name;
        $tag->color = $tagData->color;
        $tag->keywords = $tagData->keywords;

        $tag->save();
    }
}
