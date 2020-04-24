<?php

namespace Domain\Analytics\Collections;

use Domain\Analytics\Models\PageCacheView;
use Illuminate\Database\Eloquent\Collection;

class PageCacheViewCollection extends Collection
{
    public function hits(): self
    {
        return $this->filter(fn (PageCacheView $pageCacheView) => $pageCacheView->is_cache_hit);
    }

    public function misses(): self
    {
        return $this->filter(fn (PageCacheView $pageCacheView) => ! $pageCacheView->is_cache_hit);
    }

    public function authenticated(): self
    {
        return $this->filter(fn (PageCacheView $pageCacheView) => $pageCacheView->user_id !== null);
    }

    public function guest(): self
    {
        return $this->filter(fn (PageCacheView $pageCacheView) => $pageCacheView->user_id === null);
    }
}
