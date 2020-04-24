<?php

namespace Domain\Analytics\Actions;

use App\Console\Jobs\PageCacheReportJob;
use Carbon\Carbon;
use Domain\Analytics\Models\PageCacheView;
use Domain\User\Models\User;

class CreatePageCacheViewAction
{
    private UpdatePageCacheReportAction $updatePageCacheReportAction;

    public function __construct(UpdatePageCacheReportAction $updatePageCacheReportAction)
    {
        $this->updatePageCacheReportAction = $updatePageCacheReportAction;
    }

    public function __invoke(
        string $url,
        Carbon $viewed_at,
        bool $isCacheHit,
        ?User $user
    ): void {
        $pageCacheView = PageCacheView::create([
            'url' => $url,
            'viewed_at' => $viewed_at,
            'is_cache_hit' => $isCacheHit,
            'user_id' => $user->id ?? null,
        ]);

        dispatch(new PageCacheReportJob($pageCacheView->viewed_at));
    }
}
