<?php

use Domain\User\Models\User;
use Faker\Factory;
use Faker\Generator;

function locale()
{
    return config('app.locale');
}

function faker(): Generator
{
    return Factory::create();
}

function current_user(): ?User
{
    return Auth::user();
}
