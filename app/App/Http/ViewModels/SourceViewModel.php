<?php

namespace App\Http\ViewModels;

use Domain\Language\LanguageRepository;
use Domain\Post\Models\Topic;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Spatie\ViewModels\ViewModel;

final class SourceViewModel extends ViewModel
{
    /** @var \Domain\User\Models\User */
    private $user;

    /** @var \Domain\Language\LanguageRepository */
    private $languageRepository;

    public function __construct(User $user, LanguageRepository $languageRepository)
    {
        $this->user = $user;
        $this->languageRepository = $languageRepository;
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
            ->mapWithKeys(fn(Topic $topic) => [$topic->id => $topic->name])
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

    public function language(): ?string
    {
        return optional($this->source())->language;
    }

    public function languageOptions(): array
    {
        return (new LanguageViewModel($this->languageRepository))->languageOptions();
    }
}
