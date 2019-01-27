<?php

namespace App\Console\Jobs;

use App\Console\Events\TagSyncedEvent;
use App\Console\Events\TopicSyncedEvent;
use Domain\Post\Actions\SyncTagAction;
use Domain\Post\Actions\SyncTopicAction;
use Domain\Post\DTO\TagData;
use Domain\Post\Models\Topic;
use Symfony\Component\Yaml\Yaml;

class SyncTagsAndTopicsJob
{
    /** @var \Domain\Post\Actions\SyncTopicAction */
    protected $syncTopicAction;

    /** @var \Domain\Post\Actions\SyncTagAction */
    protected $syncTagAction;

    public function __construct(
        SyncTopicAction $syncTopicAction,
        SyncTagAction $syncTagAction
    ) {
        $this->syncTopicAction = $syncTopicAction;
        $this->syncTagAction = $syncTagAction;
    }

    public function handle()
    {
        $definition = Yaml::parse(file_get_contents(base_path('app/tags.yaml')));

        foreach ($definition['topics'] as $topicName) {
            $this->syncTopicAction->__invoke($topicName);

            event(new TopicSyncedEvent($topicName));
        }

        foreach ($definition['tags'] as $tagName => $tagData) {
            $this->syncTagAction->__invoke(
                TagData::new(
                    $tagName,
                    $tagData['color'],
                    $tagData['keywords'],
                    $tagData['topic']
                        ? Topic::whereName($tagData['topic'])->first()
                        : null
                )
            );

            event(new TagSyncedEvent($tagName));
        }
    }
}
