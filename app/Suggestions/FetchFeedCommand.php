<?php

namespace App\Suggestions;

use App\Suggestions\Events\FeedUriFetchEmpty;
use App\Suggestions\Events\FeedUriFetchFailed;
use App\Suggestions\Events\FeedUriFound;
use App\Suggestions\Events\FeedUrisFetchFailed;
use App\Suggestions\Events\FeedUrisResolved;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use Tempest\EventBus\EventBus;
use Tempest\EventBus\EventHandler;

final readonly class FetchFeedCommand
{
    use HasConsole;

    public function __construct(
        private EventBus $eventBus,
    ) {}

    #[ConsoleCommand('fetch:feed')]
    public function __invoke(string $uri): void
    {
        $this->eventBus->listen($this->onFeedUriFetchFailed(...));
        $this->eventBus->listen($this->onFeedUriFound(...));
        $this->eventBus->listen($this->onFeedUrisResolved(...));
        $this->eventBus->listen($this->onFeedUrisFetchFailed(...));

        new FindSuggestionFeedUri()($uri);
    }

    public function onFeedUriFetchFailed(FeedUriFetchFailed $event): void
    {
        $this->error("{$event->uri}: failed");
    }

    public function onFeedUriFound(FeedUriFound $event): void
    {
        $this->success("{$event->uri}: found");
    }

    public function onFeedUrisResolved(FeedUrisResolved $event): void
    {
        $this->info('Following URIs will be checked:');

        foreach ($event->uris as $uri) {
            $this->info("  - {$uri}");
        }
    }

    public function onFeedUrisFetchFailed(FeedUrisFetchFailed $event): void
    {
        $this->error("{$event->exception->getMessage()}");
    }
}