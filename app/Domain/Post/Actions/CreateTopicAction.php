<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\TopicData;
use Domain\Post\Models\Topic;

final class CreateTopicAction
{
    public function __invoke(TopicData $topicData): Topic
    {
        return Topic::create([
            'name' => $topicData->name,
        ]);
    }
}
