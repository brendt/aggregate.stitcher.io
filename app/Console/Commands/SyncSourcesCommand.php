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

    protected $signature = 'sync:sources';

    protected $description = 'Sync sources';

    public function __construct(SyncSourceAction $syncSourceAction)
    {
        $this->syncSourceAction = $syncSourceAction;

        parent::__construct();
    }

    public function handle()
    {
        $sources = Source::whereActive()->get();

        foreach ($sources as $source) {
            dispatch(new SyncSourceJob(
                $this->syncSourceAction,
                $source
            ));

            $this->comment("Updated {$source->url} ({$source->uuid})");
        }
    }
}
