<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Topic;
use Domain\Post\Models\View;
use Domain\Post\Models\Vote;
use Domain\Source\Models\Source;
use Illuminate\Support\Collection;
use Spatie\Period\Period;
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
}
