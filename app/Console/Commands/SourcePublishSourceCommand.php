<?php

namespace App\Console\Commands;

use App\Jobs\PublishSourceJob;
use App\Models\Source;
use Illuminate\Console\Command;

class SourcePublishSourceCommand extends Command
{
    protected $signature = 'source:publish {source}';

    public function handle()
    {
        $sourceId = $this->argument('source');

        $source = Source::query()
            ->where(
                is_numeric($sourceId) ? 'id' : 'name',
                $sourceId
            )
            ->first();

        dispatch(new PublishSourceJob($source));
    }
}
