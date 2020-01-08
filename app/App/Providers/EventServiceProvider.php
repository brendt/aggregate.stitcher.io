<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Support\PageCache\PageCacheSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        PageCacheSubscriber::class,
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
