<?php

namespace App\Http\ViewModels;

use App\Http\Requests\Request;
use Domain\Post\Models\Post;
use Domain\Post\Models\View;
use Domain\Post\Models\Vote;
use Domain\Source\Models\Source;
use Illuminate\Support\Collection;
use Spatie\Period\Period;
use Spatie\ViewModels\ViewModel;

final class AdminAnalyticsViewModel extends ViewModel
{
    /** @var \App\Http\Requests\Request */
    private $request;

    /** @var int */
    private $totalViewCount;

    /** @var int */
    private $totalVoteCount;

    /** @var int */
    private $totalSourceCount;

    /** @var int int */
    private $totalPostCount;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->totalPostCount = Post::count();
        $this->totalSourceCount = Source::count();
        $this->totalVoteCount = Vote::count();
        $this->totalViewCount = View::count();
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
        return $this->totalViewCount;
    }

    public function totalVoteCount(): int
    {
        return $this->totalVoteCount;
    }

    public function totalSourceCount(): int
    {
        return $this->totalSourceCount;
    }

    public function totalPostCount(): int
    {
        return $this->totalPostCount;
    }

    public function averageViewsPerSource(): float
    {
        return round($this->totalViewCount / $this->totalSourceCount);
    }

    public function averageViewsPerPost(): float
    {
        return round($this->totalViewCount / $this->totalPostCount, 3);
    }

    public function averageVotesPerSource(): float
    {
        return round($this->totalVoteCount / $this->totalSourceCount);
    }

    public function averageVotesPerPost(): float
    {
        return round($this->totalVoteCount / $this->totalPostCount, 3);
    }

    public function averageViewsPerDay(): int
    {
        $viewCount = View::query()
            ->where('created_at', '>=' , now()->subDays(30))
            ->count();

        return $viewCount / 31;
    }

    public function averageVotesPerDay(): float
    {
        $voteCount = Vote::query()
            ->where('created_at', '>=' , now()->subDays(30))
            ->count();

        return round($voteCount / 31, 3);
    }

    public function averagePostsPerSource(): int
    {
        return $this->totalPostCount / $this->totalSourceCount;
    }

    public function viewsPerDay(): Collection
    {
        $period = Period::make(now()->subDays(30), now());

        /** @var \Domain\Post\Collections\ViewCollection $views */
        $views = View::query()
            ->where('created_at', '>=' , $period->getStart())
            ->get();

        return $views->spreadForPeriod($period);
    }

    public function votesPerDay(): Collection
    {
        $period = Period::make(now()->subDays(30), now());

        /** @var \Domain\Post\Collections\VoteCollection $votes */
        $votes = Vote::query()
            ->where('created_at', '>=' , $period->getStart())
            ->get();

        return $votes->spreadForPeriod($period);
    }
}
