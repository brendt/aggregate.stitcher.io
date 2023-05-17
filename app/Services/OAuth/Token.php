<?php

namespace App\Services\OAuth;

use League\OAuth2\Client\Token\AccessToken;

enum Token: string
{
    case TWITTER = "twitter";
    case REDDIT = "reddit";

    public function put(array $token): AccessToken
    {
        file_put_contents(storage_path("{$this->value}_oauth"), json_encode($token));

        return $this->get();
    }

    public function get(): AccessToken
    {
        return new AccessToken(
            json_decode(
                json: file_get_contents(storage_path("{$this->value}_oauth")),
                associative: true
            )
        );
    }
}
