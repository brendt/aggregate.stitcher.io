<?php

namespace App\Console\Commands;

use App\Jobs\PublishSourceJob;
use App\Jobs\SyncSourceJob;
use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'import';

    public function handle()
    {
        $urls = explode(PHP_EOL, file_get_contents(__DIR__ . '/../../../database/seeders/sources.txt'));

        foreach ($urls as $url) {
            if (! $url) {
                continue;
            }

            if (Source::query()->where('url', $url)->exists()) {
                $this->comment("Skipped {$url}");

                continue;
            }

            $source = Source::create([
                'url' => $url,
                'state' => SourceState::PUBLISHED,
            ]);

            dispatch(new SyncSourceJob($source));

            $this->info("Created {$source->name}");
        }

        $this->info("Done");
    }
}
