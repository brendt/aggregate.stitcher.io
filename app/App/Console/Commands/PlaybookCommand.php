<?php

namespace App\Console\Commands;

use App\Console\Playbook;
use App\Console\PlaybookDefinition;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class PlaybookCommand extends Command
{
    protected $signature = 'playbook:run {playbook} {--clean}';

    protected $description = 'Setup the database against a predefined playbook';

    protected $ranDefinitions = [];

    public function handle()
    {
        if (app()->environment() !== 'local') {
            $this->error('This command can only be run in the local environment!');
        }

        if ($this->option('clean')) {
            $this->migrate();
        }

        $playbookDefinition = $this->resolvePlaybookDefinition($this->argument('playbook'));

        $this->runPlaybook($playbookDefinition);
    }

    protected function migrate()
    {
        $this->info('Clearing the database');

        $this->call('migrate:fresh');
    }

    protected function runPlaybook(PlaybookDefinition $definition)
    {
        foreach ($definition->playbook->before() as $before) {
            $this->runPlaybook(
                $this->resolvePlaybookDefinition($before)
            );
        }

        for ($i = 1; $i <= $definition->times; $i++) {
            if ($definition->once && $this->definitionHasRun($definition)) {
                break;
            }

            $this->infoRunning($definition->playbook, $i);

            $definition->playbook->run($this->input, $this->output);

            $definition->playbook->hasRun();

            $this->ranDefinitions[$definition->id] = ($this->ranDefinitions[$definition->id] ?? 0) + 1;
        }

        foreach ($definition->playbook->after() as $after) {
            $this->runPlaybook(
                $this->resolvePlaybookDefinition($after)
            );
        }
    }

    protected function resolvePlaybookDefinition($class): PlaybookDefinition
    {
        if ($class instanceof PlaybookDefinition) {
            return $class;
        }

        if ($class instanceof Playbook) {
            return new PlaybookDefinition(get_class($class));
        }

        $className = $class;

        if (! Str::startsWith($class, ["\\App\\Console\\Playbooks", "App\\Console\\Playbooks"])) {
            $className = "\\App\\Console\\Playbooks\\{$class}";
        }

        return new PlaybookDefinition($className);
    }

    protected function infoRunning(Playbook $playbook, int $i)
    {
        $playbookName = get_class($playbook);

        $this->info("Running playbook `{$playbookName}` (#{$i})");
    }

    protected function definitionHasRun(PlaybookDefinition $definition): bool
    {
        return isset($this->ranDefinitions[$definition->id]);
    }
}
