<?php

namespace App\Providers;

use Support\PageCache\PageCacheSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
