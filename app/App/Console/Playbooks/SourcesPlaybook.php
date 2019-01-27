<?php

namespace App\Console\Playbooks;

use App\Console\Playbook;
use Domain\Source\Events\CreateSourceEvent;
use Domain\User\Actions\CreateUserAction;
use Domain\User\Models\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SourcesPlaybook extends Playbook
{
    /** @var \Domain\User\Actions\CreateUserAction */
    protected $createUserAction;

    public function __construct(CreateUserAction $createUserAction)
    {
        $this->createUserAction = $createUserAction;
    }

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
            'https://sebastiandedeyne.com/feed' => 'info@sebastiandedeyne.com',
        ];

        foreach ($sources as $url => $email) {
            $user = User::whereEmail($email)->firstOr(function () use ($email) {
                return $this->createUserAction->__invoke($email, bcrypt('secret'));
            });

            event(new CreateSourceEvent($url, $user->uuid, true));

            $output->writeln("- Created source {$url}");
        }
    }
}
