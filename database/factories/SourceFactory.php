<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Domain\Source\Models\Source;
use Domain\User\Models\User;

$factory->define(Source::class, function () {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'is_active' => true,
        'website' => faker()->url,
        'url' => faker()->url,
    ];
});
