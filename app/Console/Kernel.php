<?php

namespace App\Console;

use App\Console\Commands\SharePostCommand;
use App\Console\Commands\SourceSyncCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SourceSyncCommand::class)->everyFifteenMinutes();
        $schedule->command(SharePostCommand::class, ['--
        no-interaction'])->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
