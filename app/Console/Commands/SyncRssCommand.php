<?php

namespace App\Console\Commands;

use App\Console\Jobs\UpdateSourceJob;
use Domain\Source\Actions\UpdateSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Console\Command;

class SyncRssCommand extends Command
{
    /** @var \Domain\Source\Actions\UpdateSourceAction */
    protected $updateSource;

    protected $signature = 'sync:rss';

    protected $description = 'Sync RSS';

    public function __construct(UpdateSourceAction $updateSource)
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
