<?php

namespace App\Posts;

use App\Posts\Events\PostSynced;
use App\Posts\Events\SourceSynced;
use App\Posts\Events\SourceSyncFailed;
use Tempest\Console\ConsoleArgument;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use Tempest\EventBus\EventBus;
use function Tempest\Support\str;

final class SyncSourcesCommand
{
    use HasConsole;

    public function __construct(
        private readonly SyncSource $syncSource,
        private readonly EventBus $eventBus,
    ) {}

    #[ConsoleCommand]
    public function __invoke(
        #[ConsoleArgument(aliases: ['-v'])]
        bool $verbose = false,
    ): void {
        if ($verbose) {
            $this->eventBus->listen($this->onPostSynced(...));
        }

        $this->eventBus->listen($this->onSourceSynced(...));
        $this->eventBus->listen($this->onSourceSyncFailed(...));

        $sources = Source::select()->where('state', SourceState::PUBLISHED->value)->all();

        $this->info(sprintf(
            "Syncing %s %s…\n",
            count($sources),
            str('source')->pluralize(count($sources)),
        ));

        foreach ($sources as $source) {
            ($this->syncSource)($source);
        }
    }

    public function onPostSynced(PostSynced $event): void
    {
        $this->writeln("  - {$event->uri}");
    }

    public function onSourceSynced(SourceSynced $event): void
    {
        $this->success($event->uri);
    }

    public function onSourceSyncFailed(SourceSyncFailed $event): void
    {
        $this->error($event->uri);
    }
}
