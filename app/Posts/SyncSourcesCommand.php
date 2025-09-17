<?php

namespace App\Posts;

use App\Posts\Events\PostSynced;
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

        $sources = Source::select()->where('state', SourceState::PUBLISHED->value)->all();

        $this->info(sprintf(
            "Syncing %s %s…\n",
            count($sources),
            str('source')->pluralize(count($sources)),
        ));

        foreach ($sources as $source) {
            $this->info($source->name);

            ($this->syncSource)($source);

            $this->success($source->name);
        }
    }

    public function onPostSynced(PostSynced $event): void
    {
        $this->writeln("  - {$event->uri}");
    }
}
