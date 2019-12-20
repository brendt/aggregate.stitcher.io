<?php

namespace App\Admin\ViewModels;

use Support\Requests\Request;
use Domain\Analytics\Analytics;
use Domain\Source\Models\Source;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

final class AdminAnalyticsViewModel extends ViewModel
{
    /** @var \Support\Requests\Request */
    private $request;

    /** @var \Domain\Analytics\Analytics */
    private $analytics;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->analytics = new Analytics();
    }

    public function topSources(): Collection
    {
        $sources = Source::query()
            ->selectRaw('sources.*, SUM(posts.view_count) AS view_count, SUM(posts.vote_count) AS vote_count')
            ->joinPosts()
            ->groupBy('sources.url')
            ->applySort($this->request)
            ->limit(10)
            ->get();

        return $sources;
    }

    public function totalViewCount(): int
    {
        return $this->analytics->totalViewCount();
    }

    public function totalVoteCount(): int
    {
        return $this->analytics->totalVoteCount();
    }

    public function totalSourceCount(): int
    {
        return $this->analytics->totalSourceCount();
    }

    public function totalPostCount(): int
    {
        return $this->analytics->totalPostCount();
    }

    public function averageViewsPerSource(): float
    {
        return $this->analytics->averageViewsPerSource();
    }

    public function averageViewsPerSourceLastMonth(): float
    {
        return $this->analytics->averageViewsPerSourceLastMonth();
    }

    public function averageViewsPerSourcePerMonth(): array
    {
        return $this->analytics->averageViewsPerSourcePerMonth();
    }

    public function averageViewsPerPost(): float
    {
        return $this->analytics->averageViewsPerPost();
    }

    public function averageVotesPerSource(): float
    {
        return $this->analytics->averageVotesPerSource();
    }

    public function averageVotesPerPost(): float
    {
        return $this->analytics->averageVotesPerPost();
    }

    public function averageViewsPerDay(): int
    {
        return $this->analytics->averageViewsPerDay();
    }

    public function averageVotesPerDay(): float
    {
        return $this->analytics->averageVotesPerDay();
    }

    public function averagePostsPerSource(): int
    {
        return $this->analytics->averagePostsPerSource();
    }

    public function viewsPerDay(): Collection
    {
        return $this->analytics->viewsPerDay();
    }

    public function votesPerDay(): Collection
    {
        return $this->analytics->votesPerDay();
    }
}
