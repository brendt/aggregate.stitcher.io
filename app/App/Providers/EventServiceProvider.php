<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\EventProjector\Projectionist;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        /** @var \Spatie\EventProjector\Projectionist $projectionist */
        $projectionist = $this->app->get(Projectionist::class);

        $projectionist->addProjectors([
            \Domain\User\Projectors\UserProjector::class,
            \Domain\Source\Projectors\SourceProjector::class,
            \Domain\Post\Projectors\VoteProjector::class,
            \Domain\Post\Projectors\ViewProjector::class,
            \Domain\Post\Projectors\PostProjector::class,
            \Domain\Post\Projectors\TopicProjector::class,
            \Domain\Post\Projectors\TagProjector::class,
            \Domain\Mute\Projectors\MuteProjector::class,
        ]);
    }
}
