<?php

namespace App\Console\Playbooks;

use App\Console\Jobs\SyncTagsAndTopicsJob;
use App\Console\Playbook;
use Domain\User\Events\CreateUserEvent;
use Domain\User\Models\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BasePlaybook extends Playbook
{
    /** @var \App\Console\Jobs\SyncTagsAndTopicsJob */
    protected $syncTagsAndTopicsJob;

    public function __construct(SyncTagsAndTopicsJob $syncTagsAndTopicsJob)
    {
        $this->syncTagsAndTopicsJob = $syncTagsAndTopicsJob;
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->syncTags();

        $output->writeln('- Synced tags');

        $this->createAdminUser();

        $output->writeln('- Admin user created');
    }

    private function syncTags()
    {
        dispatch_now($this->syncTagsAndTopicsJob);
    }

    private function createAdminUser()
    {
        event(CreateUserEvent::create('brent@stitcher.io', bcrypt('secret')));

        $user = User::whereEmail('brent@stitcher.io')->first();

        $user->is_admin = true;
        $user->is_verified = true;

        $user->save();
    }
}
