<?php

namespace App\Console\Playbooks;

use App\Console\Jobs\SyncTagsAndTopicsJob;
use App\Console\Playbook;
use Domain\User\Actions\CreateUserAction;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BasePlaybook extends Playbook
{
    /** @var \App\Console\Jobs\SyncTagsAndTopicsJob */
    private $syncTagsAndTopicsJob;

    /** @var \Domain\User\Actions\CreateUserAction */
    private $createUserAction;

    public function __construct(
        SyncTagsAndTopicsJob $syncTagsAndTopicsJob,
        CreateUserAction $createUserAction
    ) {
        $this->syncTagsAndTopicsJob = $syncTagsAndTopicsJob;
        $this->createUserAction = $createUserAction;
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $this->syncTags();

        $output->writeln('- Synced tags');

        $this->createAdminUser();

        $output->writeln('- Admin user created');
    }

    private function syncTags(): void
    {
        dispatch_now($this->syncTagsAndTopicsJob);
    }

    private function createAdminUser(): void
    {
        $user = ($this->createUserAction)->__invoke('brent@stitcher.io', bcrypt('secret'));

        $user->is_admin = true;
        $user->is_verified = true;

        $user->save();
    }
}
