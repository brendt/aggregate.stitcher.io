<?php

namespace App\Console\Playbooks;

use App\Console\Jobs\SyncSourceJob;
use App\Console\Playbook;
use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\Models\Source;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PostsPlaybook extends Playbook
{
    /** @var \Domain\Source\Actions\SyncSourceAction */
    protected $syncSourceAction;

    public function __construct(SyncSourceAction $syncSourceAction)
    {
        $this->syncSourceAction = $syncSourceAction;
    }

    public function before(): array
    {
        return [
            SourcesPlaybook::once(),
        ];
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        foreach (Source::all() as $source) {
            $output->writeln("- Syncing source {$source->url}");

            $syncSourceJob = new SyncSourceJob($this->syncSourceAction, $source);

            dispatch_now($syncSourceJob);

            $output->writeln("  <info>Success</info>");
        }
    }
}
