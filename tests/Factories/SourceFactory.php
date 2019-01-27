<?php

namespace Tests\Factories;

use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Tests\Mocks\MockMailer;

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
            return User::create([
                'email' => $this->email,
                'name' => $this->email,
                'password' => bcrypt('secret'),
                'verification_token' => 'test',
            ]);
        });

        return (new CreateSourceAction(new MockMailer()))->__invoke(
            $user,
            new SourceData([
                'url' => $this->url,
                'is_active' => true,
            ])
        );
    }

    public function withUrl(string $url): SourceFactory
    {
        $factory = clone $this;

        $factory->url = $url;

        return $factory;
    }
}
