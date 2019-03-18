<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Topic;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Spatie\ViewModels\ViewModel;

class SourceViewModel extends ViewModel
{
    /** @var \Domain\User\Models\User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function source(): ?Source
    {
        return $this->user->getPrimarySource();
    }

    public function url(): ?string
    {
        return optional($this->source())->url;
    }

    public function twitterHandle(): ?string
    {
        return optional($this->source())->twitter_handle;
    }

    public function topicOptions(): array
    {
        return Topic::all()
            ->mapWithKeys(function (Topic $topic) {
                return [$topic->id => $topic->name];
            })
            ->prepend(__('-'), null)
            ->toArray();
    }

    public function primaryTopicId(): ?int
    {
        $source = $this->source();

        if (! $source) {
            return null;
        }

        return optional($source->getPrimaryTopic())->id;
    }
}
