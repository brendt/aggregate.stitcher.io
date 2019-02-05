<?php

namespace App\Console\Commands;

use App\Console\Jobs\SyncSourceJob;
use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Console\Command;

final class SyncSourcesCommand extends Command
{
    /** @var \Domain\Source\Actions\SyncSourceAction */
    protected $syncSourceAction;

    protected $signature = 'sync:sources {url?} {--filter=}';

    protected $description = 'Sync sources';

    public function __construct(SyncSourceAction $syncSourceAction)
    {
        parent::__construct();

        $this->syncSourceAction = $syncSourceAction;
    }

    public function handle(): void
    {
        $sources = Source::whereActive()->get();

        if ($this->argument('url')) {
            $sources = $sources->filter(function (Source $source) {
                return $source->url === $this->argument('url');
            });
        }

        if ($this->option('filter')) {
            $filterUrl = $this->option('filter');

            $this->syncSourceAction->setFilterUrl($filterUrl);

            $sources = $sources->filter(function (Source $source) use ($filterUrl) {
                return $source->website === parse_url($filterUrl, PHP_URL_HOST);
            });
        }

        foreach ($sources as $source) {
            dispatch(new SyncSourceJob(
                $this->syncSourceAction,
                $source
            ));

            $this->comment("Updated {$source->url} ({$source->uuid})");
        }
    }
}
