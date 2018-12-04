<?php

namespace App\Console\Commands;

use App\Console\Jobs\UpdateSourceJob;
use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Console\Command;

class SyncRssCommand extends Command
{
    /** @var \Domain\Source\Actions\SyncSourceAction */
    protected $updateSource;

    protected $signature = 'rss:sync';

    protected $description = 'Sync RSS';

    public function __construct(SyncSourceAction $updateSource)
    {
        $this->updateSource = $updateSource;

        parent::__construct();
    }

    public function handle()
    {
        foreach (Source::all() as $source) {
            dispatch(new UpdateSourceJob(
                $this->updateSource,
                $source
            ));

            $this->comment("Updated {$source->url}");
        }
    }
}
