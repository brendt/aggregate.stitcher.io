<?php

namespace App\Posts;

use Tempest\Database\IsDatabaseModel;
use Tempest\Database\Virtual;
use Tempest\DateTime\DateTime;
use Tempest\Router\Bindable;
use function Tempest\Support\str;

final class Post implements Bindable
{
    use IsDatabaseModel;

    public string $title;
    public string $uri;
    public DateTime $createdAt;
    public Source $source;
    public PostState $state = PostState::PENDING;
    public int $visits;

    #[Virtual]
    public string $cleanUri {
        get {
            return strtok($this->uri, '?');
        }
    }
}
