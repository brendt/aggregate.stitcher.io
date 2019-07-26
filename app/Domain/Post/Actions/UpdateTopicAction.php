<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\TopicData;
use Domain\Post\Models\Topic;

final class UpdateTopicAction
{
    public function __invoke(
        Topic $topic,
        TopicData $topicData
    ): void {
        if (! $topicData->hasChanges($topic)) {
            return;
        }

        $topic->name = $topicData->name;

        $topic->save();
    }
}
