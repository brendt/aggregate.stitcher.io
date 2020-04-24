<?php

namespace Domain\Analytics\Actions;

use Carbon\Carbon;
use Domain\Analytics\Models\PageCacheReport;
use Domain\Analytics\Models\PageCacheView;

class UpdatePageCacheReportAction
{
    public function __invoke(Carbon $day): void
    {
        $pageCacheReport = PageCacheReport::where('day', $day->format('Y-m-d'))->first();

        if (! $pageCacheReport) {
            $pageCacheReport = PageCacheReport::create([
                'day' => $day,
            ]);
        }

        $pageCacheViews = PageCacheView::query()
            ->where('viewed_at', '>=', $day->copy()->startOfDay())
            ->where('viewed_at', '<=', $day->copy()->endOfDay())
            ->get();

        $pageCacheReport->update([
            'cache_hits' => $pageCacheViews->hits()->count(),
            'authenticated_cache_hits' => $pageCacheViews->hits()->authenticated()->count(),
            'guest_cache_hits' => $pageCacheViews->hits()->guest()->count(),
            'cache_misses' => $pageCacheViews->misses()->count(),
            'authenticated_cache_misses' => $pageCacheViews->misses()->authenticated()->count(),
            'guest_cache_misses' => $pageCacheViews->misses()->guest()->count(),
        ]);
    }
}
