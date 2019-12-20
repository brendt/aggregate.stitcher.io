<?php

namespace Domain\Post\DTO;

use App\Admin\Requests\AdminTopicRequest;
use Domain\Post\Models\Topic;
use Spatie\DataTransferObject\DataTransferObject;

class TopicData extends DataTransferObject
{
    /** @var string */
    public $name;

    public static function new(
        string $name
    ): TopicData {
        return new self(compact('name'));
    }

    public static function fromRequest(AdminTopicRequest $adminTopicRequest): TopicData
    {
        return new self([
            'name' => $adminTopicRequest->get('name'),
        ]);
    }

    public function hasChanges(Topic $topic): bool
    {
        return $topic->name !== $this->name;
    }
}
