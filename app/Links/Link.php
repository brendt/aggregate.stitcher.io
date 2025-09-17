<?php

namespace App\Links;

use Tempest\Database\IsDatabaseModel;

final class Link
{
    use IsDatabaseModel;

    public string $uuid;
    public string $uri;
    public ?string $title;
    public int $visits;
}