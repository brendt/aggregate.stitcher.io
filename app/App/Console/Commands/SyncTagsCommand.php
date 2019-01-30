<?php

namespace App\Console\Commands;

use App\Console\Events\TagSyncedEvent;
use App\Console\Events\TopicSyncedEvent;
use App\Console\Jobs\SyncTagsAndTopicsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

final class SyncTagsCommand extends Command
{
    protected $signature = 'sync:tags';

    protected $description = 'Sync tags from their YAML definition';

    /** @var \App\Console\Jobs\SyncTagsAndTopicsJob */
    protected $syncTagsAndTopicsJob;

    public function __construct(SyncTagsAndTopicsJob $syncTagsAndTopicsJob)
    {
        parent::__construct();

        $this->syncTagsAndTopicsJob = $syncTagsAndTopicsJob;
    }

    public function handle(): void
    {
        Event::listen(TopicSyncedEvent::class, [$this, 'topicSynced']);
        Event::listen(TagSyncedEvent::class, [$this, 'tagSynced']);

        dispatch_now($this->syncTagsAndTopicsJob);
    }

    public function topicSynced(TopicSyncedEvent $event): void
    {
        $this->comment("Synced topic {$event->topicName}");
    }

    public function tagSynced(TagSyncedEvent $event): void
    {
        $this->comment("Synced tag {$event->tagName}");
    }
}
