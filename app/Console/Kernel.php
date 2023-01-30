<?php

namespace App\Console;

use App\Console\Commands\SourceSyncCommand;
use App\Console\Commands\TweetRandomPostCommand;
use App\Console\Commands\TwitterSyncCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SourceSyncCommand::class)->everyFifteenMinutes();
        $schedule->command(TwitterSyncCommand::class)->everyFiveMinutes();
//        $schedule->command(TweetRandomPostCommand::class)->mondays()->at('11:01');
//        $schedule->command(TweetRandomPostCommand::class)->wednesdays()->at('10:26');
//        $schedule->command(TweetRandomPostCommand::class)->fridays()->at('11:10');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
