<?php

namespace App\Console\Commands;

use App\Jobs\PublishSourceJob;
use App\Models\Source;
use Illuminate\Console\Command;

class PublishSourceCommand extends Command
{
    protected $signature = 'publish {source}';

    public function handle()
    {
        $source = Source::findOrFail($this->argument('source'));

        dispatch(new PublishSourceJob($source));
    }
}
