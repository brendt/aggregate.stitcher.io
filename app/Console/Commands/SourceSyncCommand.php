<?php

namespace App\Console\Commands;

use App\Jobs\SyncSourceJob;
use App\Models\Source;
use Illuminate\Console\Command;
use Throwable;

class SourceSyncCommand extends Command
{
    protected $signature = 'source:sync {--source=}';

    public function handle()
    {
        $filter = $this->option('source');

        if ($filter) {
            $sources = Source::query()
                ->where(
                    is_numeric($filter) ? 'id' : 'name',
                    $filter
                )
                ->get();
        } else {
            $sources = Source::all();
        }

        foreach ($sources as $source) {
            $this->comment("Syncing source <fg=green>{$source->name}</> (#{$source->id})");

            try {
                dispatch(new SyncSourceJob($source));
            } catch (Throwable $e) {
                $this->output->writeln("\t[<fg=green>{$source->name}</> (#{$source->id})] <bg=red;fg=white>{$e->getMessage()}</>");
            }
        }
    }
}
