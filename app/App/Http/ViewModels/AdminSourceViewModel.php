<?php

namespace App\Http\ViewModels;

use Domain\Language\LanguageRepository;
use Domain\Post\Models\Topic;
use Domain\Post\Models\View;
use Domain\Post\Models\Vote;
use Domain\Source\Models\Source;
use Illuminate\Support\Collection;
use Spatie\Period\Period;
use Spatie\ViewModels\ViewModel;

final class AdminSourceViewModel extends ViewModel
{
    /** @var \Domain\Source\Models\Source */
    private $source;

    /** @var \Domain\Language\LanguageRepository */
    private $languageRepository;

    public function __construct(Source $source, LanguageRepository $languageRepository)
    {
        $this->source = $source;
        $this->languageRepository = $languageRepository;
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
            ->mapWithKeys(fn (Topic $topic) => [$topic->id => $topic->name])
            ->toArray();
    }

    public function topicOptions(): array
    {
        return Topic::all()
            ->mapWithKeys(fn (Topic $topic) => [$topic->id => $topic->name])
            ->toArray();
    }

    public function isValidated(): bool
    {
        return $this->source->is_validated;
    }

    public function isActive(): bool
    {
        return $this->source->is_active;
    }

    public function viewsPerDay(): Collection
    {
        $period = Period::make(now()->subDays(30), now());

        /** @var \Domain\Post\Collections\ViewCollection $views */
        $views = View::query()
            ->whereSource($this->source)
            ->where('created_at', '>', $period->getStart())
            ->get();

        return $views->spreadForPeriod($period);
    }

    public function votesPerDay(): Collection
    {
        $period = Period::make(now()->subDays(30), now());

        /** @var \Domain\Post\Collections\VoteCollection $votes */
        $votes = Vote::query()
            ->whereSource($this->source)
            ->where('created_at', '>', $period->getStart())
            ->get();

        return $votes->spreadForPeriod($period);
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
