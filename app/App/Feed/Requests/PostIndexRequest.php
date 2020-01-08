<?php

namespace App\Feed\Requests;

use Domain\Post\Models\Topic;
use Support\Requests\Request;

class PostIndexRequest extends Request
{
    /** @var \Domain\Post\Models\Topic|null */
    private $topic;

    public function withTopic(Topic $topic): PostIndexRequest
    {
        $this->topic = $topic;
    }

    public function getTopicSlug(): ?string
    {
        return $this->get('filter')['topic'] ?? optional($this->topic)->slug;
    }

    public function getTagSlug(): ?string
    {
        return $this->get('filter')['tag'] ?? null;
    }
}
