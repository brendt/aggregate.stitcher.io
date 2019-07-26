<?php

namespace App\Console\Commands;

use Domain\Source\Actions\ValidateSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Console\Command;

final class ValidateSourcesCommand extends Command
{
    protected $signature = 'validate:sources';

    protected $description = 'Sync sources';

    /** @var \Domain\Source\Actions\ValidateSourceAction */
    private $validateSourceAction;

    public function __construct(ValidateSourceAction $validateSourceAction)
    {
        parent::__construct();

        $this->validateSourceAction = $validateSourceAction;
    }

    public function handle(): void
    {
        $sources = Source::whereNotValidated()->get();

        foreach ($sources as $source) {
            $this->validateSourceAction->execute($source);
        }
    }
}
