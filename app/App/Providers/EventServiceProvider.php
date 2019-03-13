<?php

namespace App\Providers;

use App\Subscribers\PageCacheSubscriber;
use App\Subscribers\TweetSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        PageCacheSubscriber::class,
        TweetSubscriber::class,
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
