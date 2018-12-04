<?php

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
