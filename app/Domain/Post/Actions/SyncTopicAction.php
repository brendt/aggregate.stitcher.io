<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\TopicData;
use Domain\Post\Models\Topic;

final class SyncTopicAction
{
    /** @var \Domain\Post\Actions\CreateTopicAction */
    private $createTopicAction;

    /** @var \Domain\Post\Actions\UpdateTopicAction */
    private $updateTopicAction;

    public function __construct(
        CreateTopicAction $createTopicAction,
        UpdateTopicAction $updateTopicAction
    ) {
        $this->createTopicAction = $createTopicAction;
        $this->updateTopicAction = $updateTopicAction;
    }

    public function __invoke(string $name): void
    {
        $existingTopic = Topic::whereName($name)->first();

        if ($existingTopic) {
            $this->updateTopicAction->__invoke($existingTopic, TopicData::new($name));

            return;
        }

        $this->createTopicAction->__invoke(TopicData::new($name));
    }
}
