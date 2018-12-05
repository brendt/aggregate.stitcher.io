<?php

namespace App\Console\Commands;

use App\Console\Jobs\UpdateSourceJob;
use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Console\Command;

class SyncSourcesCommand extends Command
{
    /** @var \Domain\Source\Actions\SyncSourceAction */
    protected $updateSource;

    protected $signature = 'sync:sources';

    protected $description = 'Sync sources';

    public function __construct(SyncSourceAction $updateSource)
    {
        $this->updateSource = $updateSource;

        parent::__construct();
    }

    public function handle()
    {
        $sources = Source::whereActive()->get();

        foreach ($sources as $source) {
            dispatch(new UpdateSourceJob(
                $this->updateSource,
                $source
            ));

            $this->comment("Updated {$source->url} ({$source->uuid})");
        }
    }
}
