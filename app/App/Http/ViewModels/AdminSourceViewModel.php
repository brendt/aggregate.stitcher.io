<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Topic;
use Domain\Post\Models\View;
use Domain\Post\Models\Vote;
use Domain\Source\Models\Source;
use Illuminate\Support\Collection;
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
        $day = now()->subMonth();

        $views = View::whereSource($this->source)
            ->where('created_at', '>', $day->toDateTimeString())
            ->get();

        $data = collect([]);

        while ($day <= now()) {
            $data[$day->toDateString()] = 0;

            $day->addDay();
        }

        /** @var \Domain\Post\Models\View $view */
        foreach ($views as $view) {
            $data[$view->created_at->toDateString()] += 1;
        }

        return $data;
    }

    public function votesPerDay(): Collection
    {
        $day = now()->subMonth();

        $votes = Vote::whereSource($this->source)
            ->where('created_at', '>', $day->toDateTimeString())
            ->get();

        $data = collect([]);

        while ($day <= now()) {
            $data[$day->toDateString()] = 0;

            $day->addDay();
        }

        /** @var \Domain\Post\Models\Vote $vote */
        foreach ($votes as $vote) {
            $data[$vote->created_at->toDateString()] += 1;
        }

        return $data;
    }
}
