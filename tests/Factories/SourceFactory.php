<?php

namespace Tests\Factories;

use Domain\Source\Events\CreateSourceEvent;
use Domain\Source\Models\Source;
use Domain\User\Actions\CreateUserAction;
use Domain\User\Models\User;

final class SourceFactory
{
    /** @var string */
    private $email;

    /** @var string */
    private $url;

    public static function new(): SourceFactory
    {
        return new self;
    }

    public function __construct()
    {
        $this->email = 'brent@stitcher.io';
        $this->url = 'https://stitcher.io/rss';
    }

    public function create(): Source
    {
        $user = User::whereEmail($this->email)->firstOr(function () {
            event(CreateUserAction::create($this->email, bcrypt('secret')));

            return User::whereEmail($this->email)->first();
        });

        event(new CreateSourceEvent($this->url, $user->uuid, true));

        return Source::whereUrl($this->url)->first();
    }

    public function withUrl(string $url): SourceFactory
    {
        $factory = clone $this;

        $factory->url = $url;

        return $factory;
    }
}
