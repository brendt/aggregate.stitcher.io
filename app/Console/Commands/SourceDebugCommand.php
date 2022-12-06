<?php

namespace App\Console\Commands;

use App\Events\PostResolved;
use App\Events\SourceDuplicationFound;
use App\Events\SourceFeedUrlFound;
use App\Events\SourceFeedUrlsResolved;
use App\Events\SourceFeedUrlTried;
use App\Jobs\PublishSourceJob;
use App\Models\Source;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;

class SourceDebugCommand extends Command
{
    protected $signature = 'source:debug {source} {--clean}';

    public function handle()
    {
        $sourceUrl = $this->argument('source');

        if (Source::where('url', $sourceUrl)->exists() && $this->option('clean')) {
            $source = Source::where('url', $sourceUrl)->first();

            $source->posts->each->delete();

            $source->delete();

            $this->info("Deleted existing source");
        }

        $source = Source::firstOrCreate([
            'url' => $sourceUrl,
        ]);

        dispatch_sync(new PublishSourceJob($source));
    }

    public function onSourceFeedUrlsResolved(SourceFeedUrlsResolved $event): void
    {
        /** @phpstan-ignore-next-line  */
        if (! $this->output) {
            return;
        }

        $this->info("[{$event->source->name}] Trying these URLs:");

        foreach ($event->feedUrls as $feedUrl) {
            $this->comment("\t- {$feedUrl}");
        }
    }

    public function onSourceFeedUrlTried(SourceFeedUrlTried $event): void
    {
        /** @phpstan-ignore-next-line  */
        if (! $this->output) {
            return;
        }

        $this->error("[{$event->source->name}] {$event->feedUrl} failed");
    }

    public function onSourceFeedUrlFound(SourceFeedUrlFound $event): void
    {
        /** @phpstan-ignore-next-line  */
        if (! $this->output) {
            return;
        }

        $this->info("[{$event->source->name}] {$event->feedUrl} succeeded!");
    }

    public function onSourceDuplicationFound(SourceDuplicationFound $event): void
    {
        /** @phpstan-ignore-next-line  */
        if (! $this->output) {
            return;
        }

        $this->error("[{$event->source->name}] already exists");
    }

    public function onPostResolved(PostResolved $event): void
    {
        /** @phpstan-ignore-next-line  */
        if (! $this->output) {
            return;
        }

        $this->info("[{$event->post->url}] synced");

        $payload = json_encode($event->payload, JSON_PRETTY_PRINT);

        $resolvedData = json_encode($event->post->toArray(), JSON_PRETTY_PRINT);

        $this->comment("[{$event->post->url}]

Raw payload:
{$payload}

<fg=green>
Resolved data:
{$resolvedData}</>
");
    }

    public function subscribe(Dispatcher $dispatcher): array
    {
        return [
            SourceFeedUrlsResolved::class => 'onSourceFeedUrlsResolved',
            SourceFeedUrlTried::class => 'onSourceFeedUrlTried',
            SourceFeedUrlFound::class => 'onSourceFeedUrlFound',
            SourceDuplicationFound::class => 'onSourceDuplicationFound',
            PostResolved::class => 'onPostResolved',
        ];
    }
}
