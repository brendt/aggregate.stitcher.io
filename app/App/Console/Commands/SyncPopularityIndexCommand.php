<?php

namespace App\Console\Commands;

use App\Console\Jobs\SyncPopularityJob;
use Domain\Analytics\Analytics;
use Domain\Post\Actions\SyncPopularityAction;
use Domain\Post\Models\Post;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SyncPopularityIndexCommand extends Command
{
    protected $signature = 'sync:popularity';

    protected $description = 'Update all post popularity indices';

    public function run(InputInterface $input, OutputInterface $output)
    {
        $analytics = new Analytics();

        $syncPopularityAction = new SyncPopularityAction(
            $analytics->averageViewsPerPost(),
            $analytics->averageVotesPerPost()
        );

        dispatch(new SyncPopularityJob($syncPopularityAction));
    }
}
