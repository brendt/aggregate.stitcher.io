<?php

declare(strict_types=1);

namespace App;

use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;

final readonly class DeployCommand
{
    use HasConsole;

    #[ConsoleCommand('deploy')]
    public function __invoke(): void
    {
        $this->info('Starting deploy');

        $this->info('Pulling changes');
        passthru("ssh forge@stitcher.io 'cd aggregate.stitcher.io && git fetch origin && git reset --hard origin/main'");
        $this->success('Done');

        $this->info('Running deploy script');
        passthru("ssh forge@stitcher.io 'cd aggregate.stitcher.io && bash deploy.sh'");

        $this->success('Deploy success');
    }
}
