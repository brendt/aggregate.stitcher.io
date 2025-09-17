<?php

namespace App\Posts;

use Tempest\Database\IsDatabaseModel;
use Tempest\Database\Virtual;
use Tempest\Router\Bindable;

final class Source implements Bindable
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
