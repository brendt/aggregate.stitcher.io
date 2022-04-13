<?php

namespace App\Console\Commands;

use App\Jobs\SyncSource;
use App\Models\Source;
use Illuminate\Console\Command;
use Throwable;

class SyncCommand extends Command
{
    protected $signature = 'sync {--source=}';

    public function handle()
    {
        if ($sourceId = $this->option('source')) {
            $sources = collect([Source::find($sourceId)]);
        } else {
            $sources = Source::all();
        }

        foreach ($sources as $source) {
            $this->comment("Syncing source <fg=green>{$source->name}</> (#{$source->id})");

            try {
                dispatch(new SyncSource($source));
            } catch (Throwable $e) {
                $this->output->writeln("\t[<fg=green>{$source->name}</> (#{$source->id})] <bg=red;fg=white>{$e->getMessage()}</>");
            }
        }
    }
}
