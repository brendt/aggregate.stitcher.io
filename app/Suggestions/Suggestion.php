<?php

namespace App\Suggestions;

use Tempest\Database\IsDatabaseModel;
use Tempest\DateTime\DateTime;
use Tempest\Router\Bindable;

final class Suggestion implements Bindable
{
    use IsDatabaseModel;

    public string $uri;
    public ?string $feedUri = null;
    public DateTime $suggestedAt;
    public string $suggestedBy;
}