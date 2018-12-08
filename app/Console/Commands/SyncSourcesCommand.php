<?php

namespace App\Console\Commands;

use App\Console\Jobs\SyncSourceJob;
use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Console\Command;

class SyncSourcesCommand extends Command
{
    /** @var \Domain\Source\Actions\SyncSourceAction */
    protected $syncSourceAction;

    protected $signature = 'sync:sources {url?} {--filter-url=}';

    protected $description = 'Sync sources';

    public function __construct(SyncSourceAction $syncSourceAction)
    {
        parent::__construct();

        $this->syncSourceAction = $syncSourceAction;
    }

    public function handle()
    {
        $sources = Source::whereActive()->get();

        if ($this->argument('url')) {
            $sources = $sources->filter(function (Source $source) {
                return $source->url === $this->argument('url');
            });
        }

        if ($this->option('filter-url')) {
            $this->syncSourceAction->setFilterUrl($this->option('filter-url'));
        }

        foreach ($sources as $source) {
            dispatch(new SyncSourceJob(
                $this->syncSourceAction,
                $source
            ));

            $this->comment("Updated {$source->url} ({$source->uuid})");
        }
    }
}
