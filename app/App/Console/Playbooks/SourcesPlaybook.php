<?php

namespace App\Console\Playbooks;

use App\Console\Playbook;
use Domain\Source\Events\CreateSourceEvent;
use Domain\User\Events\CreateUserEvent;
use Domain\User\Models\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SourcesPlaybook extends Playbook
{
    public function before(): array
    {
        return [
            BasePlaybook::once(),
        ];
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->createSources($output);
    }

    private function createSources(OutputInterface $output)
    {
        $sources = [
            'https://stitcher.io/rss' => 'brent@stitcher.io',
        ];

        foreach ($sources as $url => $email) {
            $user = User::whereEmail($email)->firstOr(function () use ($email) {
                event(CreateUserEvent::create($email, bcrypt('secret')));

                return User::whereEmail($email)->first();
            });

            event(new CreateSourceEvent($url, $user->uuid, true));

            $output->writeln("- Created source {$url}");
        }
    }
}
