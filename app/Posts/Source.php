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
    public int $visits;
    public int $rank;

    public SourceState $state = SourceState::PENDING;

    #[Virtual]
    public bool $isExternals {
        get => $this->name === 'https://externals.io';
    }

    #[Virtual]
    public bool $isPending {
        get => $this->state === SourceState::PENDING;
    }

    #[Virtual]
    public bool $isDenied {
        get => $this->state === SourceState::DENIED;
    }

    #[Virtual]
    public bool $isPublished {
        get => $this->state === SourceState::PUBLISHED;
    }
}
