<?php

namespace App\Posts;

use Tempest\Database\IsDatabaseModel;
use Tempest\Database\Virtual;

final class Source
{
    use IsDatabaseModel;

    public string $name;
    public string $uri;
    public SourceState $state = SourceState::PENDING;

    #[Virtual]
    public bool $isExternals {
        get => $this->name === 'externals.io';
    }
}
