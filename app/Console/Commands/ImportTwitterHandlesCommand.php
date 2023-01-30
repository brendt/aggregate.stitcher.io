<?php

namespace App\Console\Commands;

use App\Actions\ResolveTwitterHandle;
use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Console\Command;

final class ImportTwitterHandlesCommand extends Command
{
    protected $signature = 'twitter:import-handles {id?}';

    public function handle(ResolveTwitterHandle $resolveTwitterHandle)
    {
        if ($id = $this->argument('id')) {
            $sources = Source::query()
                ->where('id', $id)
                ->get()
                ->values();
        } else {
            $sources = Source::query()
                ->where('state', SourceState::PUBLISHED)
                ->whereNull('twitter_handle')
                ->get()
                ->values();
        }

        $count = $sources->count();

        foreach ($sources as $i => $source) {
            $i += 1;
            $this->comment("[{$source->name}] {$i}/{$count}");

            $handle = $resolveTwitterHandle($source);

            if (! $handle) {
                continue;
            }

            $this->info("\t{$handle}");
        }
    }
}
