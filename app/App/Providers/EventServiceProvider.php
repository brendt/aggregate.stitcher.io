<?php

namespace App\Providers;

use App\Subscribers\PostSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        PostSubscriber::class,
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
