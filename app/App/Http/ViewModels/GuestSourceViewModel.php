<?php

namespace App\Http\ViewModels;

use Domain\Language\LanguageRepository;
use Domain\Post\Models\Topic;
use Spatie\ViewModels\ViewModel;

class GuestSourceViewModel extends ViewModel
{
    /** @var \Domain\Language\LanguageRepository */
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function topicOptions(): array
    {
        return Topic::all()
            ->mapWithKeys(fn(Topic $topic) => [$topic->id => $topic->name])
            ->prepend(__('-'), null)
            ->toArray();
    }

    public function languageOptions(): array
    {
        return (new LanguageViewModel($this->languageRepository))->languageOptions();
    }
}
