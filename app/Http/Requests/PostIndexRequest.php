<?php

namespace App\Http\Requests;

class PostIndexRequest extends Request
{
    public function getTopicSlug(): ?string
    {
        return $this->get('filter')['topics.slug'] ?? null;
    }

    public function getTagSlug(): ?string
    {
        return $this->get('filter')['tags.slug'] ?? null;
    }
}
