<?php

namespace App\Console\Commands;

use App\Console\Jobs\UpdateViewCountJob;
use App\Console\Jobs\UpdateVoteCountJob;
use Illuminate\Console\Command;

final class SyncPostCountCommand extends Command
{
    protected $signature = 'sync:post-count';

    protected $description = 'Sync post count statistics';

    public function handle(): void
    {
        dispatch(app(UpdateViewCountJob::class));

        dispatch(app(UpdateVoteCountJob::class));

        $this->info('Jobs dispatched');
    }
}
