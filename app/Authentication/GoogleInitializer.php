<?php

namespace App\Authentication;

use League\OAuth2\Client\Provider\Google;
use Tempest\Container\Container;
use Tempest\Container\Initializer;
use Tempest\Container\Singleton;
use function Tempest\env;

final readonly class GoogleInitializer implements Initializer
{
    #[Singleton]
    public function initialize(Container $container): Google
    {
        return new Google([
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri' => env('GOOGLE_REDIRECT_URI'),
        ]);
    }
}
