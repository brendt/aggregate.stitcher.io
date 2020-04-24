<?php

namespace App\Admin\ViewModels;

use Domain\Analytics\Models\PageCacheReport;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

final class AdminPageCacheReportsModel extends ViewModel
{
    private Collection $pageCacheReports;

    public function __construct(Collection $pageCacheReports)
    {
        $this->pageCacheReports = $pageCacheReports;
    }

    public function days()
    {
        return $this->pageCacheReports
            ->map(fn(PageCacheReport $pageCacheReport) => $pageCacheReport->day->format('Y-m-d'));
    }

    public function hits()
    {
        return $this->pageCacheReports
            ->map(fn(PageCacheReport $pageCacheReport) => $pageCacheReport->cache_hits);
    }

    public function misses()
    {
        return $this->pageCacheReports
            ->map(fn(PageCacheReport $pageCacheReport) => $pageCacheReport->cache_misses);
    }
}
