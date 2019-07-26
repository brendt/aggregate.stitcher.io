<?php

namespace Domain\Source\Actions;

use Domain\Post\Models\Topic;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\Source\Models\SourceTopic;

final class ResolveTopicsAction
{
    public function execute(Source $source, SourceData $sourceData): void
    {
        foreach ($sourceData->topic_ids as $topicId) {
            $this->resolveTopic($source, Topic::findOrFail($topicId));
        }

        $this->detachTopics($source, $sourceData->topic_ids);
    }

    private function resolveTopic(Source $source, Topic $topic): void
    {
        if ($source->topics->find($topic->id)) {
            return;
        }

        SourceTopic::create([
            'source_id' => $source->id,
            'topic_id' => $topic->id,
        ]);
    }

    private function detachTopics(Source $source, array $topicIds): void
    {
        SourceTopic::query()
            ->whereSource($source)
            ->whereNotIn('topic_id', $topicIds)
            ->delete();
    }
}
