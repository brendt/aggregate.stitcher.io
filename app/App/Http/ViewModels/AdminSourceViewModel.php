<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Topic;
use Domain\Source\Models\Source;
use Spatie\ViewModels\ViewModel;

class AdminSourceViewModel extends ViewModel
{
    /** @var \Domain\Source\Models\Source */
    protected $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function source(): ?Source
    {
        return $this->source;
    }

    public function url(): string
    {
        return $this->source->url;
    }

    public function twitterHandle(): ?string
    {
        return $this->source->twitter_handle;
    }

    public function topics(): array
    {
        return $this->source->topics
            ->mapWithKeys(function (Topic $topic) {
                return [$topic->id => $topic->name];
            })
            ->toArray();
    }

    public function topicOptions(): array
    {
        return Topic::all()
            ->mapWithKeys(function (Topic $topic) {
                return [$topic->id => $topic->name];
            })
            ->toArray();
    }
}
