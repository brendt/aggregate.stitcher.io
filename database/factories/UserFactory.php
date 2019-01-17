<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Domain\User\Models\User;

$factory->define(User::class, function () {
    return [
        'name' => faker()->name,
        'email' => faker()->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'verification_token' => 'test',
    ];
});
