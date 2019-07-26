<?php

namespace App\Http\Requests;

abstract class SourceRequest extends Request
{
    public function getTopicIds(): array
    {
        return $this->get('topic_ids', []);
    }

    public function getTwitterHandle(): ?string
    {
        return $this->get('twitter_handle');
    }

    public function getSourceUrl(): string
    {
        return $this->get('url');
    }
}
