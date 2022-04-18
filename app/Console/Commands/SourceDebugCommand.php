<?php

namespace App\Console\Commands;

use App\Events\SourceFeedUrlFound;
use App\Events\SourceFeedUrlsResolved;
use App\Events\SourceFeedUrlTried;
use App\Jobs\PublishSourceJob;
use App\Models\Source;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;

class SourceDebugCommand extends Command
{
    protected $signature = 'source:debug {source}';

    public function handle()
    {
        $sourceUrl = $this->argument('source');

        $source = Source::firstOrCreate([
            'url' => $sourceUrl,
        ]);

        dispatch_sync(new PublishSourceJob($source));
    }

    public function onSourceFeedUrlsResolved(SourceFeedUrlsResolved $event): void
    {
        $this->info("[{$event->source->name}] Trying these URLs:");

        foreach ($event->feedUrls as $feedUrl) {
            $this->comment("\t- {$feedUrl}");
        }
    }

    public function onSourceFeedUrlTried(SourceFeedUrlTried $event): void
    {
        $this->error("[{$event->source->name}] {$event->feedUrl} failed");
    }

    public function onSourceFeedUrlFound(SourceFeedUrlFound $event): void
    {
        $this->info("[{$event->source->name}] {$event->feedUrl} succeeded!");
    }

    public function subscribe(Dispatcher $dispatcher): array
    {
        return [
            SourceFeedUrlsResolved::class => 'onSourceFeedUrlsResolved',
            SourceFeedUrlTried::class => 'onSourceFeedUrlTried',
            SourceFeedUrlFound::class => 'onSourceFeedUrlFound',
        ];
    }
}
