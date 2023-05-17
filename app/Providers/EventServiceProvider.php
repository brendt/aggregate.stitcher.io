<?php

namespace App\Providers;

use App;
use App\Console\Commands\SourceDebugCommand;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Reddit\RedditExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            RedditExtendSocialite::class . '@handle',
        ],
    ];

    public function boot()
    {
        if (App::runningInConsole()) {
            Event::subscribe(SourceDebugCommand::class);
        }
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
